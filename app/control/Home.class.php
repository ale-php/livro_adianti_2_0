<?php

class Home extends TPage
{
  private $html;
  /**
  * Class constructor
  * Creates the page
  */
  function __construct()
  {
    parent::__construct();
    TSession::freeSession();
    TPage::include_css('app/view/css/login.css');
    $this->html = new THtmlRenderer('app/view/frmLogin.html');
    // define replacements for the main section
    $replace = array();
    // replace the main section variables
    $this->html->enableSection('main', $replace);
    // add the template to the page
    parent::add($this->html);
  }
  public function logar($param){
    $login = Usuario::logar($param['login'],$param['senha']);
    if($login){
    
    
      foreach($login as $l):
        TSession::setValue('user',$l); // guardamos o objeto usuario
        TSession::setValue('user_login',true); // valor true para logado
        TSession::setValue('permissao',$l->permissao); // guardo somentea permissão
      endforeach;
      
      AdiantiCoreApplication::gotoPage('ClienteList');
      
    }else{
       new TMessage('info',print_r($param),null,'Erro ao logar');
    }
  }
  public function logout(){
    TSession::freeSession();
    AdiantiCoreApplication::gotoPage('Home');
  }
}
?>
