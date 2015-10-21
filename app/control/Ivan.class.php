<?php

class Ivan extends TPage
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

        TPage::include_css('app/resources/css/home.css');

        $this->html = new THtmlRenderer('app/resources/home.html');

        // define replacements for the main section
        $replace = array();
        
        // replace the main section variables
        $this->html->enableSection('main', $replace);
        
        // add the template to the page
        parent::add($this->html);
    }
    
    
    function logar(){
    
   
    
    
    }


}
?>
