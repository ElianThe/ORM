<?php

namespace catadoct\catalog\domain\entities;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: "produit")]
class Produit
{
    #[Id]
    #[Column(type: Types::INTEGER)]
    #[GeneratedValue(strategy: "AUTO")]
    private int $id;

    #[Column(type: Types::INTEGER)]
    private int $numero;

    #[Column(type: Types::STRING)]
    private string $libelle;

    #[Column(type: Types::STRING)]
    private string $description;

    #[Column(type: Types::STRING)]
    private string $image;

    #[OneToOne(targetEntity: Categorie::class)]
    private string $categorie_id;
}