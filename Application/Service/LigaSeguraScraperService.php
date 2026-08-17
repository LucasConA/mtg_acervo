<?php

namespace App\AcervoMtg\Application\Service;

use DOMDocument;
use DOMXPath;

class LigaSeguraScraperService
{
    /**
     * Scrapes the price for a specific card config from a LigaSegura store.
     *
     * @param string $domain The store domain (e.g. www.meruru.com.br, www.epicgame.com.br, bazardebagda.com.br)
     * @param string $nome Card name (English or Portuguese)
     * @param string $edicaoNome Name of the edition (from DB)
     * @param string $condicaoCodigo Condition abbreviation (e.g. NM, SP)
     * @param bool $foil Whether the card is foil
     * @return array|null Array with ['preco' => float, 'condicao' => string] or null if not found
     */
    public function obterPreco(string $domain, string $nome, string $edicaoNome, string $condicaoCodigo, bool $foil): ?array
    {
        $baseUrl = "https://" . preg_replace('/^https?:\/\//', '', $domain);
        $url = $baseUrl . "/?view=ecom/itens&tcg=1&busca=" . urlencode($nome);
        
        $html = $this->fetchHtml($url);

        if (!$html) {
            return null;
        }

        $dom = new DOMDocument();
        @$dom->loadHTML('<?xml encoding="UTF-8">' . $html);
        $xpath = new DOMXPath($dom);

        // Check if directly on details page
        $rows = $xpath->query('//div[contains(@class, "table-cards-row")]');
        if ($rows->length > 0) {
            return $this->parseDetailsPageRows($xpath, $rows, $edicaoNome, $condicaoCodigo, $foil);
        }

        // Search results page
        $cardItems = $xpath->query('//div[contains(@class, "card-item")]');
        if ($cardItems->length === 0) {
            return null;
        }

        $normalizedSearchName = $this->normalizeString($nome);
        $bestMatchUrl = null;

        foreach ($cardItems as $item) {
            $titleNode = $xpath->query('.//div[@class="card-desc"]/div[@class="title"]/a', $item)->item(0);
            if (!$titleNode) {
                continue;
            }

            $scrapedTitle = trim($titleNode->textContent);
            $href = $titleNode->getAttribute('href');
            $normalizedScrapedTitle = $this->normalizeString($scrapedTitle);
            
            if ($normalizedScrapedTitle === $normalizedSearchName) {
                $bestMatchUrl = $href;
                break;
            }
        }

        if (!$bestMatchUrl) {
            $firstTitleNode = $xpath->query('.//div[@class="card-desc"]/div[@class="title"]/a', $cardItems->item(0))->item(0);
            if ($firstTitleNode) {
                $bestMatchUrl = $firstTitleNode->getAttribute('href');
            }
        }

        if (!$bestMatchUrl) {
            return null;
        }

        if (str_starts_with($bestMatchUrl, '.')) {
            $bestMatchUrl = $baseUrl . substr($bestMatchUrl, 1);
        } elseif (str_starts_with($bestMatchUrl, '/')) {
            $bestMatchUrl = $baseUrl . $bestMatchUrl;
        }

        $detailHtml = $this->fetchHtml($bestMatchUrl);
        if (!$detailHtml) {
            return null;
        }

        $detailDom = new DOMDocument();
        @$detailDom->loadHTML('<?xml encoding="UTF-8">' . $detailHtml);
        $detailXpath = new DOMXPath($detailDom);

        $detailRows = $detailXpath->query('//div[contains(@class, "table-cards-row")]');
        return $this->parseDetailsPageRows($detailXpath, $detailRows, $edicaoNome, $condicaoCodigo, $foil);
    }

    private function parseDetailsPageRows(DOMXPath $xpath, $rows, string $edicaoNome, string $condicaoCodigo, bool $foil): ?array
    {
        $normalizedEdicao = $this->normalizeString($edicaoNome);
        $normalizedCondicao = strtolower($condicaoCodigo);

        $exactMatch = null;
        $fallbackMatch = null;

        foreach ($rows as $row) {
            $cells = $xpath->query('./div[contains(@class, "table-cards-body-cell")]', $row);
            
            $rowEdicao = '';
            $rowQuality = '';
            $rowExtras = '';
            $rowPrice = '';

            foreach ($cells as $cell) {
                $class = $cell->getAttribute('class');
                $text = trim(preg_replace('/\s+/', ' ', $cell->textContent));

                if (str_contains($class, 'card-preco')) {
                    $rowPrice = $text;
                } elseif (str_contains($class, 'card-extras')) {
                    $rowExtras = $text;
                } elseif (str_contains($class, 'quality')) {
                    $rowQuality = $text;
                } elseif (str_contains($text, 'Edição')) {
                    $rowEdicao = $text;
                }
            }

            $cleanEdicao = str_replace('Edição ', '', $rowEdicao);
            $normalizedCleanEdicao = $this->normalizeString($cleanEdicao);

            // Match Edition
            if ($normalizedCleanEdicao !== $normalizedEdicao && 
                !str_contains($normalizedCleanEdicao, $normalizedEdicao) && 
                !str_contains($normalizedEdicao, $normalizedCleanEdicao)) {
                continue;
            }

            // Match Foil Status
            $isRowFoil = str_contains(strtolower($rowExtras), 'foil');
            if ($foil !== $isRowFoil) {
                continue;
            }

            // Parse Price
            $priceClean = str_replace(['Preço', 'R$', ' ', '.'], '', $rowPrice);
            $priceClean = str_replace(',', '.', $priceClean);
            if (!is_numeric($priceClean)) {
                continue;
            }
            $price = (float)$priceClean;

            // Parse scraped quality
            $scrapedQuality = $this->cleanQualityCode($rowQuality);

            // Exact Condition match?
            $normalizedQuality = strtolower($rowQuality);
            $isExactQuality = (str_contains($normalizedQuality, '(' . $normalizedCondicao . ')') || 
                               str_contains($normalizedQuality, 'qualidade ' . $normalizedCondicao));

            if ($isExactQuality) {
                $exactMatch = [
                    'preco' => $price,
                    'condicao' => $scrapedQuality
                ];
                break; // Stop loop, exact match found!
            } else {
                if ($fallbackMatch === null) {
                    $fallbackMatch = [
                        'preco' => $price,
                        'condicao' => $scrapedQuality
                    ];
                }
            }
        }

        return $exactMatch ?? $fallbackMatch;
    }

    private function cleanQualityCode(string $qualityText): string
    {
        if (preg_match('/\(([^)]+)\)/', $qualityText, $matches)) {
            return strtoupper(trim($matches[1]));
        }
        $code = str_replace('Qualidade ', '', $qualityText);
        return strtoupper(trim(explode(' ', $code)[0]));
    }

    private function fetchHtml(string $url): ?string
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $html = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200 && $html) {
            return $html;
        }

        return null;
    }

    private function normalizeString(string $str): string
    {
        $str = strtolower($str);
        $unwanted_array = [
            'á'=>'a', 'à'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
            'é'=>'e', 'è'=>'e', 'ê'=>'e', 'ë'=>'e', 'í'=>'i', 'ì'=>'i', 'î'=>'i', 'ï'=>'i',
            'ñ'=>'n', 'ó'=>'o', 'ò'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'œ'=>'o',
            'ú'=>'u', 'ù'=>'u', 'û'=>'u', 'ü'=>'u', 'ý'=>'y', 'ÿ'=>'y'
        ];
        $str = strtr($str, $unwanted_array);
        $str = preg_replace('/[^a-z0-9]/', '', $str);
        return $str;
    }
}
