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

$p = $produitRepository->find(1);
print $p->libelle . "\n";