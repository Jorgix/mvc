<?php

$dir = require_once __DIR__ . '/vendor/autoload.php';

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
  $results = $search->map(function($result){
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
