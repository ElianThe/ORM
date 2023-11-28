<?php

namespace iutnc\hellokant\model;

use iutnc\hellokant\query\Query;

abstract class Model {

    protected static $table;
    protected static $idColumn;

    protected $atts;

    public function __construct(array $fillable = [])
    {
        $this->_atts = $fillable;

    }

    public function __get($nom) {
        if (method_exists($this, $nom)) {
            return $this->$nom();
        }
        return array_key_exists($nom, $this->data) ? $this->data[$nom] : null;
    }

    public function __set($name, $value)
    {
        if (in_array($name, $this->atts)) {
            $this->atts[$name] = $value;
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

    public function belongs_to($table, $foreign_key): Query {
        return Query::table(static::$table)
            ->innerJoin($table, $foreign_key, static::$idColumn)
            ->one();
    }

    public function has_many($table, $foreign_key): array {
        return Query::table(static::$table)
            ->innerJoin($table, $foreign_key, static::$idColumn)
            ->get();
    }


}