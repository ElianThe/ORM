<?php

use Doctrine\ORM\EntityManager;

$conn = "";
$config = "";


// obtaining the Doctrine entity manager
$entityManager = EntityManager::create($conn, $config);