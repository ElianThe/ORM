<?php

use catadoct\catalog\domain\entities\Produit;
use catadoct\catalog\domain\entities\Categorie;
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
$categorieRep = $entityManager->getRepository(Categorie::class);

/*
//afficher le produit d'identifiant 4 : id, numéro, libellé, description, image.
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
*/

//afficher la catégorie 5.
/*
$categorie = $categorieRep->find(5);
if ($categorie) {
    echo $categorie->getId() . "\n";
    echo $categorie->getLibelle() . "\n";
} else {
    echo "Categorie non trouvée";
}*/



//compléter le script 1.1 pour afficher la catégorie du produit.
/*
$produit = $produitRepository->find(4);
if ($produit) {
    echo $produit->getCategorie()->getLibelle() . "\n";
}*/

/*
//Afficher tous les produits de la catégorie 5.
$categorie = $categorieRep->find(5);
echo "les produits de la categorie 5 : " . "\n";
foreach ($categorie->getProduits() as $produit) {
    echo $produit->getLibelle() . "\n";
}*/

//Créer un produit et le relier à la catégorie 5, faire en sorte qu'il soit sauvegardé dans la base.
$produitN = new Produit();
$produitN->setNumero(11);
$produitN->setLibelle("Quatro Fromagi");
$produitN->setDescription("Quatro Fromagi");
$produitN->setImage("https://www.dominos.fr/ManagedAssets/FR/product/PZSO.png");
$entityManager->persist($produitN);
$produitN->setCategorie($categorieRep->find(5));


//Modifier ce produit et mettre à jour la base

//Supprimer ce produit et mettre à jour la base.