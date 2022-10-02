<?php


namespace App\Http\Middleware;

class Queue

{
    /**
     * Mapeamento dos middlewares
     * @var array
     * 
     */
    private static $map = [];

    /**
     * Fila de Middlewares a serem executados
     * @var array
     */
    private $middlewares = [];

    /**
     * Função de execução do controlador
     * @var Closure
     */
    private $controller;

    /**
     * Argumentos da função do controlador
     * @var array
     */
    private $controllerArgs = [];

    /**
     * @param array
     * @param Closure
     * @param array
     */
    public function __construct($middlewares, $controller, $controllerArgs)
    {
        $this->middlewares    = $middlewares;
        $this->controller     = $controller;
        $this->controllerArgs = $controllerArgs;
    }

    /**
     * Método responsável por definir o mapeamento de middlewares
     * @param array $map
     */
    public static function setMap($map){
        self::$map = $map;
    }

    /**
     * Método responsável por executar o próximo nível da fila de middlewares
     * @param  Request $request
     * @return Response
     */
    public function next($request){

        //VERIFICA SE A FILA ESTÁ VAZIA
        if(empty($this->middlewares)) return call_user_func_array($this->controller, $this->controllerArgs);

    }
}
