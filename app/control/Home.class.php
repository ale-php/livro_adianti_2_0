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

        TPage::include_css('app/resources/css/login.css');

        $this->html = new THtmlRenderer('app/resources/frmLogin.html');

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
            TSession::setValue('permissao',$l->permissao); // guardo somente a permissão
                endforeach;

        AdiantiCoreApplication::loadPage('ClientesList');
        }

    }

    public function logout(){


      TSession::freeSession();

        AdiantiCoreApplication::gotoPage('Home');
    }
}
?>
