<?php

use \App\Http\Response;
use \App\Controller\Pages;


// ROTA HOME
$router->get('/', [
    function () {
        return new Response(200, Pages\Home::getHome());
    }
]);

// ROTA USUARIOS AD
$router->get('/usuarios-ad', [
    function ($request) {
        return new Response(200, Pages\Userad::getUserad($request));
    }
]);

// ROTA USUARIOS AD (INSERT)
$router->post('/usuarios-ad', [
    function ($request) {
        //MÉTODO POST ESTÁ RECEBENDO OS DADOS DO POST VIA $REQUEST
        return new Response(200, Pages\Userad::insertUserAd($request));
    }
]);
