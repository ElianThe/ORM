<?php

namespace iutnc\hellokant\query;

class Query
{
    private string $sqlTable;
    private $fields = '*';
    private $where = null;
    private $args = [];
    private $sql = '';

    public static function table(string $table): Query
    {
        $query = new Query();
        $query->sqlTable = $table;
        return $query;
    }

    public function where(string $col, string $op, mixed $val): Query
    {
        $this->args[] = $val;
        $this->where .= ($this->where == null) ? " WHERE $col $op ?" : " AND WHERE $col $op ?";
        return $this;
    }

    public function get(): void
    {
        $this->sql = "SELECT $this->fields FROM $this->sqlTable".$this->where;
        var_dump($this->sql);
    }

    public function select(string ...$cols): Query
    {
        /**
        foreach ($cols as $col)
            $this->fields .= (array_key_last($cols) !== $col) ? $col . "," : $col ; */
        $this->fields = implode(",",$cols);
        return $this;
    }

    public function delete(): void
    {
        $this->sql = "DELETE FROM $this->sqlTable" . $this->where;
        var_dump($this->sql);
    }

    public function insert(array $newRow): void
    {
        $row = implode(",",$newRow);
        $this->sql = "INSERT INTO $this->sqlTable VALUES ($row)" . $this->where;
        var_dump($this->sql);
    }
}