<?php

namespace iutnc\hellokant\query;

use iutnc\hellokant\factory\ConnectionFactory;

class Query
{
    private string $sqlTable;
    private $fields = '*';
    private $where = null;
    private $args = [];
    private $sql = '';

    /**
     * @param string $sqlTable
     */
    public function __construct(string $sqlTable)
    {
        $this->sqlTable = $sqlTable;
        ConnectionFactory::makeConnection(parse_ini_file("conf.ini"));
    }

    public function one(){
        $pdo = ConnectionFactory::getConnection();

        $pdo->query(<<<SQL
                    SELECT $this->fields 
                    FROM $this->sqlTable 
                    $this->where
                    $this->sql;
                 SQL);
        $this->sql .= " LIMIT 1";
        return $this;
    }


    public static function table(string $table): Query
    {
        return new Query($table);
    }

    public function where(string $col, string $op, mixed $val): Query
    {
        $this->args[] = $val;
        $this->where .= ($this->where == null) ? " WHERE $col $op ?" : " AND WHERE $col $op ?";
        return $this;
    }

    public function get(): bool|\PDOStatement
    {
        $pdo = ConnectionFactory::getConnection();

        return $pdo->query(<<<SQL
                    SELECT $this->fields 
                    FROM $this->sqlTable 
                    $this->where;
                 SQL);

    }

    public function select(string ...$cols): Query
    {
        $this->fields = implode(",",$cols);
        return $this;
    }

    public function delete(): bool|int
    {
        $pdo = ConnectionFactory::getConnection();

        return $pdo->exec(<<<SQL
                    DELETE;
                    FROM $this->sqlTable
                    $this->where;
                    SQL);
    }

    public function insert(array $newRow): bool|string
    {
        $row = implode(",",$newRow);
        $pdo = ConnectionFactory::getConnection();

        $pdo->exec(<<<SQL
            INSERT INTO $this->sqlTable 
            VALUES ($row)
            $this->where;
            SQL);
        return $pdo->lastInsertId();
    }
}