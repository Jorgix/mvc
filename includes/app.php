<?php

require __DIR__ . '/../vendor/autoload.php';

use \App\Utils\View;
use \WilliamCosta\DotEnv\Environment;
use \WilliamCosta\DatabaseManager\Database;
use Adldap\Adldap;
use Adldap\AdldapException;
use Adldap\Auth\BindException;


Database::config(
    'localhost',
    'projeto_ad',
    'root',
    12345,
    3306
);


//CARREGA VARIÁVEIS DE AMBIENTE
Environment::load(__DIR__ . '/../');

//DEFINE A CONSTANTE DE URL
define('URL', getenv('URL'));

//DEFINE O VALOR PADRÃO DAS VARIÁVEIS
View::init([
    'URL' => URL
]);
