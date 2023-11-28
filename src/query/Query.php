<?php

namespace iutnc\hellokant\query;

use iutnc\hellokant\factory\ConnectionFactory;

class Query
{
    private $sqltable;
    private $fields = '*';
    private $where = null;
    private $args = [];
    private $sql = '';

    public static function table(string $table) : Query {
        $query = new Query();
        $query->sqltable = $table;
        return $query;
    }

    public function one(): Query {
        $this->sql = 'select '.$this->fields.' from '.$this->sqltable;

        if ($this->where) {
            $this->sql .= ' where '.$this->where;
        }

        $this->sql.=' LIMIT = 1';

//        $request = $pdo->prepare($this->sql);
//        $request->execute($this->args);
//        return $request->fetchAll(PDO::FETCH_ASSOC);

        return $this;
    }

    public function select(array $fields) : Query {
        $this->fields = implode(', ', $fields);
        return $this;
    }

    public function where(string $col, string $op, mixed $val) : Query {
        $this->where = "$col $op ?";
        $this->args[] = $val;
        return $this;
    }

    public function get() : array {
        $this->sql = 'select '.$this->fields.' from '.$this->sqltable;

        if ($this->where) {
            $this->sql .= ' where '.$this->where;
        }

//        $request = $pdo->prepare($this->sql);
//        $request->execute($this->args);
//        return $request->fetchAll(PDO::FETCH_ASSOC);

        return ['sql' => $this->sql];
    }

    public function save() : Query {
        if ($this->where) {
            $this->sql .= ' where '.$this->where;
        }
        return $this;
    }

    public function insert(array $args) {
        $cols = implode(', ', array_keys($args));
        $vals = implode(', ', array_fill(0, count($args), '?'));
        $this->args = array_values($args);

        $this->sql = 'insert into '.$this->sqltable.' ('.$cols.') values ('.$vals.')';
    }

    public function update(array $args ): Query {
        $this->sql = 'update '.$this->sqltable.' set ';

        $cols = implode(', ', array_keys($args));
        $vals = implode(', ', array_fill(0, count($args), '?'));
        $this->args = array_values($args);

        $this->sql .= $cols.' = '.$vals;

        return $this;
    }

    public function delete($id): bool {
        //$conf = parse_ini_file('../../conf/db.conf.ini');

        //ConnectionFactory::makeConnection($conf);
        //$request = ConnectionFactory::getConnection();

        $this->sql = 'delete from '.$this->sqltable. ' where id = '.$id;

        //$request->prepare($this->sql);
        //$request->exec($id);
        return true;
    }

    public function innerJoin(string $table, string $col1, string $col2): Query {
        $this->sql .= ' inner join '.$table.' on '.$col1.' = '.$col2;
        return $this;
    }


}