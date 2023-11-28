<?php

namespace iutnc\hellokant\model;

use iutnc\hellokant\query\Query;

abstract class Model {

    protected static $table;
    protected static $idColumn = 'id';

    protected $atts;

    public function __construct(array $fillable = [])
    {
        $this->atts = $fillable;
    }

    public function __get($name)
    {
        if (in_array($name, $this->atts)) {
            return $this->$name;
        }
        return null;
    }

    public function __set($name, $value)
    {
        if (in_array($name, $this->atts)) {
            $this->$name = $value;
        }
    }

    public function save() {
        if (isset($this->atts[static::$idColumn])) {
            $this->update();
            var_dump("updated");
        } else {
            $this->insert($this->atts);
            var_dump("created");
        }
    }

    public function update() {
        Query::table(static::$table)
            ->update($this->atts);
    }

    public function delete() {

        return Query::table(static::$table)
            ->delete(static::$idColumn);

    }

    public function find(mixed $parametres, array $fields = []) {
        $query = Query::table(static::$table)->select($fields);

        if (is_int($parametres)) {
            $query->where(static::$idColumn, '=', $parametres);
        } elseif (is_array($parametres) && count($parametres) === 3) {
            $query->where($parametres[0], $parametres[1], $parametres[2]);
        } elseif (is_array($parametres) && count($parametres[0]) === 3) {
            foreach ($parametres as $param) {
                $query->where($param[0], $param[1], $param[2]);
            }
        }

        $rows = $query->get();
        $models = [];

        foreach ($rows as $row) {
            $models[] = new static((array)$row);
        }

        return $models;
    }


    public static function first(int $id): Model {

        $row = Query::table(static::$table)
            ->where(static::$idColumn, '=', $id)
            ->one();

        return new static($row);
    }

    public static function all(): array {
        $all = Query::table(static::$table)
            ->get();
        $return = [];
        foreach ($all as $m) {
            $return[] = new static((array)$m);
        }
        return $return;
    }

    public static function insert(array $args) {
        Query::table(static::$table)
            ->insert($args);
    }

    public function belongs_to($table, $foreign_key): Model {
        return $this;
    }

    public function has_many($table, $foreign_key): Model {
        return $this;
    }


}