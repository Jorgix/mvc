<?php


namespace App\Controller\Pages;



use \App\Model\Entity\UsersAd;
use \App\Utils\View;
use \WilliamCosta\DatabaseManager\Pagination;
use Adldap\Adldap;


class Userad extends Page
{
    /**
     * Método responsável por obter a renderização dos itens de usuários do AD para página
     * @param Request
     * @return string
     */
    private static function getUsersItems($request, &$obPagination)
    {

        //USUÁRIOS
        $itens = '';

        $quantidadetotal = UsersAd::getUsersAd(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //PÁGINA ATUAL
        $queryParams = $request->getQueryParams();

        $paginaAtual = $queryParams['page'] ?? 1;

        //INSTÂNCIA DE PAGINAÇÃO
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 6);

        //RESULTADOS DA PÁGINA
        $results = UsersAd::getUsersAd(null, 'id DESC', $obPagination->getLimit());

        //RENDERIZA O ITEM
        while ($obUsersAd = $results->fetchObject(UsersAd::class)) {

            //VIEW DE USUÁRIOS DO ACTIVE DIRECTORY
            $itens .= View::render('pages/listuser/item', [
                'id'            => $obUsersAd->id,
                'usuario'       => $obUsersAd->usuario,
                'nivelacesso'   => $obUsersAd->nivelacesso,
                'cpf'           => $obUsersAd->cpf,
                'status'        => $obUsersAd->status,
                'descricao'     => $obUsersAd->descricao,
                'data'          => date('d/m/Y H:i:s', strtotime($obUsersAd->data)),
            ]);
        }
        //RETORNA OS USUÁRIOS
        return $itens;
    }

    /**
     * Método responsável por retornar o conteúdo (view) de usuários do Active Directory
     * @param Request
     * @return string
     */
    public static function getUserad($request)
    {
        //VIEW DE USUÁRIOS DO ACTIVE DIRECTORY
        $content = View::render('pages/usersad', [
            'item' => self::getUsersItems($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination)
        ]);

        //RETORNA A VIEW DA PÁGINA
        return parent::getPage('Listagem do active directory', $content);
    }

    /**
     * Método responsável por cadastrar um usuário ad
     * @param Request $request
     * @return string
     */
    public static function insertUserAd($request)
    {

        $ad = new \Adldap\Adldap();

        // Create a configuration array.
        $config = [
            'hosts'    => ['solasstec.local', '192.168.25.5'],
            'base_dn'  => 'cn=users,dc=solasstec,dc=local',
            'username' => 'CN=Administrador,CN=Users,DC=Solasstec,DC=local',
            'password' => 'Admin123',
        ];

        $ad->addProvider($config);


        try {
            $provider = $ad->connect();
            echo 'Conectou com sucesso';

            $search = $provider->search();
            $search = $search->users()->get();
            $results = $search->map(function ($result) {
                // return [
                //   'cn' => $result->getAttribute('cn')
                // ];
                return [
                    "cn" => $result->cn,
                    "cpf" => $result->cpf
                ];
            });

            for ($i = 0; $i < count($results); $i++) {
                var_dump($results[$i]);
            }
            //var_dump($results->getAttribute('cn'));
        } catch (Adldap\Auth\BindException $e) {
            echo 'Falha ao conectar';
        }

        var_dump($ad);
        die;


        //DADOS RECUPERADOS DO POST
        $postVars = $request->getPostVars();

        //NOVA INSTÂNCIA DE USUÁRIO
        $obUsersAd = new UsersAd;
        $obUsersAd->usuario     = $postVars['usuario'];
        $obUsersAd->nivelacesso = $postVars['nivel-de-acesso'];
        $obUsersAd->cpf         = $postVars['cpf'];
        $obUsersAd->status      = $postVars['status'];
        $obUsersAd->descricao   = $postVars['descricao'];
        $obUsersAd->cadastrar();

        //RETORNA A PÁGINA DE LISTAGEM DE USUÁRIOS
        return self::getUserad($request);
    }
}
