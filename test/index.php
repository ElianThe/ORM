<?php
declare(strict_types=1);

session_start();

require_once ("../vendor/autoload.php");
require_once('../src/model/Article.php');
require_once('../src/model/Model.php');

$app = App::create();
$app

$tableau = ['id' => 1, 'nom' => "Dupont", 'prenom' => "Jean"];
$a = new \iutnc\hellokant\model\Article($tableau);

var_dump($a->get());