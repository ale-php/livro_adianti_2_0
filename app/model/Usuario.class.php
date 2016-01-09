<?php
/**
* Usuario Active Record
* @author  Alexandre
*/
class Usuario extends TRecord
{
  const TABLENAME = 'usuario';
  const PRIMARYKEY= 'id';
  const IDPOLICY =  'max'; // {max, serial}
  
  
  /**
  * Constructor method
  */
  public function __construct($id = NULL, $callObjectLoad = TRUE)
  {
    parent::__construct($id, $callObjectLoad);
    parent::addAttribute('login');
    parent::addAttribute('senha');
    parent::addAttribute('permissao');
    parent::addAttribute('nome');
  }
  
  public static function logar($user,$senha){
    try{
      TTransaction::open('sample');
      $criteria = new TCriteria();
      
      
    
    $criteria->add(new TFilter('login','=',$user));
    $criteria->add(new TFilter('senha','=',md5($senha)));
    $login = parent::getObjects($criteria);
    if($login){
      return $login;
    }
    else{
      new TMessage('info','Usuario ou Senha invalidos',null,'Erro ao l\
      ogar');
      AdiantiCoreApplication::loadPage('Home');
    }
    TTransaction::close();
  }catch (Exception $e){
    new TMessage('error',$e->getMessage(),null,'Erro ao logar');
  }
}
public function checkLogin(){
  if(!TSession::getValue('user_login')){
    new TMessage('info','Usuario ou Senha invalidos',null,'Erro ao logar');
    AdiantiCoreApplication::loadPage('Home');
  }
}
public static function permissao($nivel){
  $user = TSession::getValue('user');
  if($user->permissao >= $nivel){
    return true;
  }
  else{
    return false;
  }
}
public static function acesso($nivel){
  $user = TSession::getValue('user');
  if( $user->permissao < $nivel){
    AdiantiCoreApplication::loadPage('Home');
  }
}
}
