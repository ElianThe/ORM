<?php

namespace iutnc\hellokant\model;

class Article extends Model
{
    protected static $table = 'articles';
    protected static $idColumn = 'id';

    protected $atts = [
        'id',
        'nom',
        'descr',
        'tarif',
        'id_categ',
    ];

    public function __construct(array $tab = [])
    {
        $this->data = $tab;
    }
    public function __get($nom) {
        if (method_exists($this, $nom)) {
            return $this->$nom();
        }
        return array_key_exists($nom, $this->data) ? $this->data[$nom] : null;
    }
    public function __set($nom, $valeur) {
        $this->data[$nom] = $valeur;
    }

    function categorie(){
        return parent::belongs_to(Categorie::class, "id_categorie");
    }
}