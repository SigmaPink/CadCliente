<?php
namespace Estela\SigmaCadastro;

use PDO;
use PDOException;

class ClienteDAO
{

    /** @var PDO */
    protected $conection;

    public function __construct()
    {
        $this->inicializar();
    }

    public function listarClientes()
    {
        $sql = "SELECT * FROM cliente";
        $clienteQuery = $this->conection->prepare($sql);
        $clienteQuery->execute();
        return $clienteQuery->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarNome($nome)
    {
        $sql = "SELECT 	* FROM cliente 
                    WHERE nome ILIKE '%$nome%'";
        $clienteQuery = $this->conection->prepare($sql);
        $clienteQuery->execute();
        return $clienteQuery->fetchAll(PDO::FETCH_ASSOC);
    }

    public function adicionarCliente($nome, $dataNasc, $email, $whatsapp)
    {
        $sql = "INSERT INTO cliente (nome, data_nascimento, email, whatsapp)
                VALUES('$nome', '$dataNasc', '$email', '$whatsapp');";
        $clienteQuery = $this->conection->prepare($sql);
        $clienteQuery->execute();
        return $clienteQuery->fetchAll(PDO::FETCH_ASSOC);
    }

    public function remover($nome)
    {
        $sql = "DELETE FROM pessoa
                    WHERE id_pessoa = $nome;";
        $clienteQuery = $this->conection->prepare($sql);
        $clienteQuery->execute();
        return $clienteQuery->fetchAll(PDO::FETCH_ASSOC);
    }

    public function editar($nome, $dataNasc, $email, $whatsapp)
    {
        $sql = "UPDATE cliente SET 	nome = '$nome',
                                    data_nascimento = '$dataNasc',
                                    email = '$email',
                                    whatsapp = '$whatsapp'
                    WHERE nome = '%$nome%'";
        $clienteQuery = $this->conection->prepare($sql);
        $clienteQuery->execute();
        return $clienteQuery->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function inicializar()
    {
        try {
            $dsn = "pgsql:host=localhost;port=5432;dbname=cad_cliente;";
            // make a database connection
            $pdo = new PDO($dsn, 'postgres', 'postgres', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

            if ($pdo) {
                $this->conection = $pdo;
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        } finally {
            if ($pdo) {
                $pdo = null;
            }
        }
    }
}
