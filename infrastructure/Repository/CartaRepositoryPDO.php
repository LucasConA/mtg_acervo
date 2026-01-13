<?php
namespace App\AcervoMtg\Infrastructure\Repository;

use App\AcervoMtg\Domain\Entity\Carta;
use App\AcervoMtg\Domain\Repository\CartaRepositoryInterface;
use App\AcervoMtg\Infrastructure\Database\PDOConnection;
use RuntimeException;

class CartaRepositoryPDO implements CartaRepositoryInterface
{
    private \PDO $pdo;

    public function __construct()
    {
        $this->pdo = PDOConnection::get();
    }
    

    public function buscarPorId(int $id): Carta
    {
        $stmt = $this->pdo->prepare("SELECT * FROM cartas WHERE id = ?");
        $stmt->execute([$id]);

        $row = $stmt->fetch();

        if (!$row) {
            throw new RuntimeException("Carta não encontrada");
        }

        return new Carta(
            (int) $row['id'],
            (string) $row['nome'],
            (int) ($row['id_edicao'] ?? 0),
            (int) ($row['id_raridade'] ?? 0),
            (int) ($row['id_condicao'] ?? 0),
            (int) ($row['id_idioma'] ?? 0),
            (int) ($row['id_tipo'] ?? 0),
            (bool) $row['foil'],
            (int) ($row['quantidade'] ?? 0),
            (float) ($row['valor'] ?? 0.0)
);

    }

    public function salvar(Carta $carta): void
    {
        $sql = "INSERT INTO cartas 
        (nome, id_edicao, id_raridade, id_condicao, id_idioma, id_tipo, foil, quantidade, valor)
        VALUES (?,?,?,?,?,?,?,?,?)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $carta->nome,
            $carta->edicao,
            $carta->raridade,
            $carta->condicao,
            $carta->idioma,
            $carta->tipo,
            $carta->foil ? 1 : 0,
            $carta->quantidade,
            $carta->valor
        ]);
    }

    public function atualizar(Carta $carta): void
    {
        $sql = "UPDATE cartas SET
            nome=?, id_edicao=?, id_raridade=?, id_condicao=?,
            id_idioma=?, id_tipo=?, foil=?, quantidade=?, valor=?
            WHERE id=?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $carta->nome,
            $carta->edicao,
            $carta->raridade,
            $carta->condicao,
            $carta->idioma,
            $carta->tipo,
            $carta->foil ? 1 : 0,
            $carta->quantidade,
            $carta->valor,
            $carta->id
        ]);
    }

    public function excluir(int $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM cartas WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function listar(?string $ordem = null): array
{
    $orderBy = match ($ordem) {
        'valor_asc'  => 'c.valor ASC',
        'valor_desc' => 'c.valor DESC',
        'nome_desc'  => 'c.nome DESC',
        default      => 'c.nome ASC',
    };

    $sql = "
        SELECT
            c.id,
            c.nome,
            e.nome_pt   AS edicao,
            r.nome      AS raridade,
            co.nome     AS condicao,
            i.nome      AS idioma,
            t.nome      AS tipo,
            c.foil,
            c.quantidade,
            c.valor
        FROM cartas c
        JOIN edicoes   e  ON e.id  = c.id_edicao
        JOIN raridades r  ON r.id  = c.id_raridade
        JOIN condicao  co ON co.id = c.id_condicao
        JOIN idiomas   i  ON i.id  = c.id_idioma
        JOIN tipos     t  ON t.id  = c.id_tipo
        ORDER BY {$orderBy}
    ";

    $stmt = $this->pdo->query($sql);

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}



    public function existeDuplicada(string $nome, int $edicao, int $idioma, int $tipo, bool $foil): bool
    {
        $stmt = $this->pdo->prepare("
            SELECT id FROM cartas
            WHERE nome = ?
            AND id_edicao = ?
            AND id_idioma = ?
            AND id_tipo = ?
            AND foil = ?
        ");

        $stmt->execute([$nome, $edicao, $idioma, $tipo, $foil ? 1 : 0]);

        return (bool) $stmt->fetch();
    }

}
?>
