<?php


class Controller extends TStandardList
{

  public function __construct()
  {
    parent::__construct();
    //checa para verificar se esta logado
    Usuario::checkLogin();
    //verifica o nivel de usuario que pode acessar
     Usuario::acesso(3);
  }

  public function checkEdit(){
    $valor = Usuario::permissao(5);
    return $valor;
  }
  public function checkDelete(){
    $valor = Usuario::permissao(5);
    return $valor;
  }

}
