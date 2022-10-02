<?php

namespace App\Http\Middleware;

class Maintenance {

    /**
     * Método responsável por executar o middleware
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
     public function hadle($request, $next){
        echo "<pre>";
        print_r($request);
        echo "<pre>";
        exit;
     }
}