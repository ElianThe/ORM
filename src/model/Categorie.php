<?php

namespace iutnc\hellokant\model;

class Categorie extends Model {
    protected static $table = 'categories';
    protected static $idColumn = 'id';

    protected $atts = [
        'id',
        'nom',
        'descr',
    ];

    public function __construct(array $tab = [])
    {
        $this->data = $tab;
    }
    public function __get($nom)
    {
        return array_key_exists($nom, $this->data) ? $this->data[$nom] : null;
    }
    public function __set($nom, $valeur)
    {
        $this->data[$nom] = $valeur;
    }

    function articles(){
        return parent::has_many(Article::class, "id_categorie");
    }

}