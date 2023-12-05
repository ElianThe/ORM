<?php

namespace catadoct\catalog\domain\entities;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: "categorie")]
class Categorie
{
    #[Id]
    #[Column (type: Types::INTEGER)]
    #[GeneratedValue(strategy: "AUTO")]
    private int $id;

    #[Column(name : "libelle",
             type: Types::STRING,
             length: 64)]
    private string $libelle;

    /**
     * @return string
     */
    public function getLibelle(): string
    {
        return $this->libelle;
    }



}