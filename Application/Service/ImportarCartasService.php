<?php
namespace App\AcervoMtg\Application\Service;

use App\AcervoMtg\Application\DTO\CartaImportadaDTO;
use App\AcervoMtg\Domain\Entity\Carta;
use App\AcervoMtg\Domain\Repository\CartaRepositoryInterface;
use PDO;

class ImportarCartasService
{
    public function __construct(
        private CartaRepositoryInterface $repository,
        private PDO $pdo
    ) {}

    public function executar(array $cartasImportadas): array
    {
        $this->pdo->beginTransaction();

        $inseridas = 0;
        $duplicadas = 0;

        try {
            foreach ($cartasImportadas as $dto) {

                if ($this->repository->existeDuplicada(
                    $dto->nome,
                    $dto->edicao,
                    $dto->idioma,
                    $dto->tipo,
                    $dto->foil
                )) {
                    $duplicadas++;
                    continue;
                }

                $carta = new Carta(
                    0,
                    $dto->nome,
                    $dto->edicao,
                    $dto->raridade,
                    $dto->condicao,
                    $dto->idioma,
                    $dto->tipo,
                    $dto->foil,
                    $dto->quantidade,
                    $dto->valor
                );

                $this->repository->salvar($carta);
                $inseridas++;
            }

            $this->pdo->commit();
            return compact('inseridas', 'duplicadas');

        } catch (\Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
}
