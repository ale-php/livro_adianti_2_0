<?php
require_once 'init.php';


try{
// abre a transação usando o arquivo sample da pasta app/config
TTransaction::open('sample');

$cliente = new Cliente();
$cliente->nome = "alexandre";
$cliente->telefone ="99999999999";
$cliente->email = "Alexandre@progs.net.br";

$cliente->save(); // salva o objeto

TTransaction::close();

print("Cliente salvo");

}catch(Exception $e){

print($e->getMessage());

}
?>
