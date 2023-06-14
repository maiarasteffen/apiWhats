<?php

namespace Mini\Core;

use PDO;

class Model
{
    /**
     * @var null Database Connection
     */
    protected $conn = null;

    /**
     * Whenever model is created, open a database connection.
     */
    function __construct()
    {
        try {
            $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);
            $this->conn = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ";charset=" . DB_CHARSET, DB_USER, DB_PASS, $options);
        } catch (\PDOException $e) {
            exit('Database connection could not be established: ' . $e);
        }
    }

    function __destruct()
    {
        $this->conn = null;
    }

    function check()
    {
        return $this->conn->getAttribute(PDO::ATTR_SERVER_INFO);
    }

    function begin()
    {
        $this->conn->beginTransaction();
    }

    function commit()
    {
        $this->conn->commit();
    }

    function rollback()
    {
        $this->conn->rollback();
    }

    //************** MAIN ***************//
    public function do($sql, $values = array())
    {
        $query = $this->conn->prepare($sql);
        $query->execute($values);
        return $query;
    }

    protected function insert(string $table, array $fields)
    {
        foreach ($fields as $index => $item) {
            $keys = implode(", ", array_keys($item));
            $valuesMarks = rtrim(str_repeat("?, ", count($item)), ", ");
            $sql = "INSERT INTO " . $table . " (" . $keys . ") VALUES (" . $valuesMarks . ")";
            $this->conn->prepare($sql)->execute(array_values($item));
        }
        // return $this->conn->lastInsertId();
    }



    protected function insertOneSql(string $table, array $fields)
    {
        $keys = "`" . implode("`, `", array_keys(reset($fields))) . "`";
        $comando = "INSERT INTO " . $table . " (" . $keys . ") VALUES ";

        $registro = $queryList = array();
        foreach ($fields as $index => $item) {
            $itens = array();
            foreach ($item as $key => $value) {
                $value = addslashes($value); //adiciona barra invertida antes de aspas
                $itens[] = (in_array($value, array("NOW()", "NULL"))) ? $value : '"' . $value . '"';  //não põe aspas se for now() ou null
            }
            $registro[] = "(" . implode(", ", $itens) . ")";

            //chegou em 1000 registros...
            //prepara o comando de insert (que será executado depois) e reseta
            if (count($registro) == 1000) {
                $queryList[] = $comando . implode(", ", $registro);
                $registro = array();
            }
        }

        //pega a rebarba
        if (count($registro) > 0) {
            $queryList[] = $comando . implode(", ", $registro);
        }

        $sucesso = 1;
        foreach ($queryList as $key => $query) {
            $result = $this->conn->prepare($query)->execute();
            if (!$result) {
                $sucesso = 0;
                echo "<hr>" . $query . "<hr>";
                die();
            }
        }

        return $sucesso;
    }

    public function delete($table)
    {
        $query = $this->conn->prepare("DELETE FROM `" . $table . "`");
        return $query->execute();
    }

    //************** SHORTCUTS (que usam function do() ) ***************//
    public function getBy($field, $value)
    {
        return $this->do("SELECT * FROM " . static::TABLE . " WHERE " . $field . " = ?", array($value))->fetch();
    }

    public function getFirst()
    {
        return $this->do("SELECT * FROM " . static::TABLE)->fetch();
    }

    public function GPinsert($arrayPost, $tabela, $retorno = false, $verQuery = false)
    {
        foreach ($arrayPost as $key => $value) {
            $arrColuna[] = $key;
            $arrColunaPdo[] = ":" . $key;
            $parameters[':' . $key] = "'" . $value . "'";
        }

        $coluna = implode(", ", $arrColuna);
        $pdo = implode(", ", $parameters);

        $sql = "INSERT INTO {$tabela} ({$coluna}) VALUES ({$pdo})";
        $result = $this->conn->prepare($sql)->execute();
        return $result;
    }

    public function update($table, $data, $id)
    {
        foreach ($data as $key => $value) {
            $arrColuna[] = $key . " = :" . $key; //Se não funcionar, substituir esse (" = :" . $key) por (" = " . $value) e só fazer um $this->conn->prepare($sql)->execute()
            $parameters[":" . $key] = $value;
        }
        $colunas = implode(", ", $arrColuna);

        $sql = "UPDATE `" . $table . "` SET {$colunas} WHERE id = {$id}";
        return $this->conn->prepare($sql)->execute($parameters);
        // return $this->do($sql, $parameters);
    }

    public function deleteList($table, array $deleteList)
    {
        $idList = implode(", ", $deleteList);
        $sql = "DELETE FROM `" . $table . "` WHERE id IN ({$idList})";
        return $this->do($sql);
    }
}
