<?php

use catadoct\catalog\domain\entities\Produit;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require_once __DIR__ . '/../vendor/autoload.php';

$entity_path = [__DIR__ . '/domain/entities/'];
$isDevMode=true;
$dbParams = parse_ini_file(__DIR__ . '/config/ticket.ini');
$config = ORMSetup::createAttributeMetadataConfiguration($entity_path, $isDevMode);
$connection = DriverManager::getConnection($dbParams, $config);
$entityManager = new EntityManager($connection, $config);

$produitRepository = $entityManager->getRepository(Produit::class);

$produit = $produitRepository->find(4);
if ($produit) {
    // Afficher les informations du produit
    echo "ID: " . $produit->getId() . "\n";
    echo "Numéro: " . $produit->getNumero() . "\n";
    echo "Libellé: " . $produit->getLibelle() . "\n";
    echo "Description: " . $produit->getDescription() . "\n";
    echo "Image: " . $produit->getImage() . "\n";
} else {
    echo "Produit non trouvé.\n";
}