<?php

namespace App\Model\Entity;

use WilliamCosta\DatabaseManager\Database;

class UsersAd
{
    /**
     * ID do usuário AD
     * @var integer
     */
    public $id;

    /**
     * Nome do usuário do AD
     * @var string
     */
    public $usuario;

    /**
     * Nível de acesso do usuário AD
     * @var string
     */
    public $nivelacesso;

    /**
     * CPF do usuário do AD
     * @var string
     */
    public $cpf;

    /**
     * Descrição do usuário no AD
     *@var string
     */
    public $descricao;

    /**
     * Descrição do usuário no AD
     *@var string
     */
    public $data;

    

    /**
     * Método responsável por cadastrar a instância atual no banco de dados
     * @return boolean
     */
    public function cadastrar()
    {   
        //DEFINE A DATA
        $this->data = date('Y-m-d H:i:s');

        //INSERI O DEPOIMENTO NO BANCO DE DADOS
        $this->id = (new Database('usuariosad'))->insert([
            'usuario' => $this->usuario,
            'nivelacesso' => $this->nivelacesso,
            'cpf' => $this->cpf,
            'status' => $this->status,
            'descricao' => $this->descricao,
            'data' => $this->data
        ]);

        //SUCESSO AO INSERIR NO BANCO DE DADOS
        return true;
    }
    /**
     * Método responsável por retornar Depoimentos
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getUsersAd($where = null, $order = null, $limit = null, $fields = '*'){
        return (new Database('usuariosad'))->select($where, $order, $limit, $fields);
    }
}
