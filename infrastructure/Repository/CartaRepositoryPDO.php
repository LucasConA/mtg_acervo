<?php
namespace App\AcervoMtg\Infrastructure\Repository;

use App\AcervoMtg\Domain\Entity\Carta;
use App\AcervoMtg\Domain\Repository\CartaRepositoryInterface;
use App\AcervoMtg\Infrastructure\Database\PDOConnection;
use App\AcervoMtg\Domain\ValueObject\Raridade;
use App\AcervoMtg\Domain\ValueObject\Condicao;
use App\AcervoMtg\Domain\ValueObject\Idioma;
use App\AcervoMtg\Domain\ValueObject\Tipo;
use RuntimeException;
use PDO;

class CartaRepositoryPDO implements CartaRepositoryInterface
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = PDOConnection::get();
    }

    /* ======================================================
     * BUSCAR POR ID
     * ====================================================== */
    public function buscarPorId(int $id): Carta
    {
        $stmt = $this->pdo->prepare("SELECT * FROM cartas WHERE id = ?");
        $stmt->execute([$id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            throw new RuntimeException("Carta não encontrada");
        }

        return new Carta(
            (int) $row['id'],
            (string) $row['nome'],
            (int) $row['id_edicao'],

            Raridade::fromId((int) $row['id_raridade']),
            Condicao::fromId((int) $row['id_condicao']),
            Idioma::fromId((int) $row['id_idioma']),
            Tipo::fromId((int) $row['id_tipo']),

            (bool) $row['foil'],
            (int) $row['quantidade'],
            (float) $row['valor']
        );
    }

    /* ======================================================
     * SALVAR
     * ====================================================== */
    public function salvar(Carta $carta): void
    {
        $sql = "
            INSERT INTO cartas 
            (nome, id_edicao, id_raridade, id_condicao, id_idioma, id_tipo, foil, quantidade, valor)
            VALUES (?,?,?,?,?,?,?,?,?)
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            $carta->nome(),
            $carta->edicao(),
            $carta->raridade()->id(),
            $carta->condicao()->id(),
            $carta->idioma()->id(),
            $carta->tipo()->id(),
            $carta->foil() ? 1 : 0,
            $carta->quantidade(),
            $carta->valor()
        ]);
    }

    /* ======================================================
     * ATUALIZAR
     * ====================================================== */
    public function atualizar(Carta $carta): void
    {
        $sql = "
            UPDATE cartas SET
                nome = :nome,
                id_edicao = :edicao,
                id_raridade = :raridade,
                id_condicao = :condicao,
                id_idioma = :idioma,
                id_tipo = :tipo,
                foil = :foil,
                quantidade = :quantidade,
                valor = :valor
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'id'         => $carta->id(),
            'nome'       => $carta->nome(),
            'edicao'     => $carta->edicao(),
            'raridade'   => $carta->raridade()->id(),
            'condicao'   => $carta->condicao()->id(),
            'idioma'     => $carta->idioma()->id(),
            'tipo'       => $carta->tipo()->id(),
            'foil'       => $carta->foil() ? 1 : 0,
            'quantidade' => $carta->quantidade(),
            'valor'      => $carta->valor(),
        ]);
    }

    /* ======================================================
     * EXCLUIR
     * ====================================================== */
    public function excluir(int $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM cartas WHERE id = ?");
        $stmt->execute([$id]);
    }

    /* ======================================================
     * EXISTE DUPLICADA
     * ====================================================== */
    public function existeDuplicada(
        string $nome,
        int $edicao,
        Idioma $idioma,
        Tipo $tipo,
        bool $foil
    ): bool {
        $stmt = $this->pdo->prepare("
            SELECT id FROM cartas
            WHERE nome = ?
              AND id_edicao = ?
              AND id_idioma = ?
              AND id_tipo = ?
              AND foil = ?
        ");

        $stmt->execute([
            $nome,
            $edicao,
            $idioma->id(),
            $tipo->id(),
            $foil ? 1 : 0
        ]);

        return (bool) $stmt->fetch();
    }
}
