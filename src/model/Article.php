<?php

namespace iutnc\hellokant\model;

class Article extends Model
{
    private array $data;
    public function __construct(array $tab = [])
    {
        $this->data = $tab;
    }
    public function __get($nom) {
        return array_key_exists($nom, $this->data) ? $this->data[$nom] : null;
    }
    public function __set($nom, $valeur) {
        $this->data[$nom] = $valeur;
    }



}