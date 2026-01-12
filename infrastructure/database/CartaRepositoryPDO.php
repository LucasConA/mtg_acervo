<?php
namespace App\AcervoMtg\Infrastructure\Database;

use App\AcervoMtg\Domain\Entity\Carta;
use App\AcervoMtg\Domain\Repository\CartaRepositoryInterface;
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
            $row['id'],
            $row['nome'],
            $row['id_edicao'],
            $row['id_raridade'],
            $row['id_condicao'],
            $row['id_idioma'],
            $row['id_tipo'],
            (bool)$row['foil'],
            $row['quantidade'],
            (float)$row['valor']
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
            'valor_asc'  => 'valor ASC',
            'valor_desc' => 'valor DESC',
            default      => 'nome ASC'
        };

        $stmt = $this->pdo->query("SELECT * FROM cartas ORDER BY $orderBy");

        $cartas = [];
        foreach ($stmt->fetchAll() as $row) {
            $cartas[] = new Carta(
                $row['id'],
                $row['nome'],
                $row['id_edicao'],
                $row['id_raridade'],
                $row['id_condicao'],
                $row['id_idioma'],
                $row['id_tipo'],
                (bool)$row['foil'],
                $row['quantidade'],
                (float)$row['valor']
            );
        }

        return $cartas;
    }
}
