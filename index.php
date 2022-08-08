<?php

require __DIR__.'/includes/app.php';

use \App\Http\Router;

//INICIA O ROUTER
$router = new Router(URL);

// INCLUI AS ROTAS DE PÁGINAS
include __DIR__ . '/routes/pages.php';

//IMPRIME O RESPONSE DA ROTA
$router->run()->sendResponse();
