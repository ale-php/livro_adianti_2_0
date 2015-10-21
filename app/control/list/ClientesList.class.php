<?php
/**
 * ClientesList Listing
 * @author  Alexandre
 */
class ClientesList extends TStandardList
{
    protected $form;     // registration form
    protected $datagrid; // listing
    protected $pageNavigation;
    
    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct()
    {
        parent::__construct();

        //checa para verificar se esta logado
        Usuario::checkLogin();
        //verifica o nivel de usuario que pode acessar
        Usuario::acesso(3);


        
        parent::setDatabase('sample');            // defines the database
        parent::setActiveRecord('Clientes');   // defines the active record
        parent::setDefaultOrder('id', 'asc');         // defines the default order
        parent::addFilterField('nome', 'like'); // add a filter field
        
        // creates the form, with a table inside
        $this->form = new TQuickForm('form_search_Clientes');
        $this->form->class = 'tform'; // CSS class
        $this->form->setFormTitle('Clientes');
        

        // create the form fields
        $nome                           = new TEntry('nome');


        // add the fields
        $this->form->addQuickField('nome', $nome,  200);



        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('Clientes_filter_data') );
        
        // add the search form actions
     
    $this->form->addQuickAction(_t('Find'), new TAction(array($this, 'onSearch')), 'bs:search blue');
    $this->form->addQuickAction(_t('New'),  new TAction(array('ClientesForm', 'onEdit')), 'bs:plus green');
    
        
        // creates a DataGrid
        $this->datagrid = new TQuickGrid;
        $this->datagrid->setHeight(320);
        

        // creates the datagrid columns
        $id = $this->datagrid->addQuickColumn('id', 'id', 'right', 100);
        $nome = $this->datagrid->addQuickColumn('nome', 'nome', 'left', 200);

        
        // create the datagrid actions
       
        $edit_action   = new TDataGridAction(array('ClientesForm', 'onEdit'));
        $edit_action->setLabel(_t('Edit'));
        $edit_action->setImage('bs:search blue');
        $edit_action->setField('id');
        $edit_action->setDisplayCondition(array($this,'checkEdit'));
        
        $delete_action = new TDataGridAction(array($this, 'onDelete'));
        $delete_action->setLabel(_t('Delete'));
        $delete_action->setImage('bs:remove red');
        $delete_action->setField('id');
        $delete_action->setDisplayCondition(array($this,'checkDelete'));


        $telefone_action = new TDataGridAction(array('telefoneList', 'onReload'));
        $telefone_action->setLabel('Telefones');
        $telefone_action->setImage('bs:search blue');
        $telefone_action->setField('id');

        $email_action = new TDataGridAction(array('emailList', 'onReload'));
        $email_action->setLabel('Email');
        $email_action->setImage('bs:search blue');
        $email_action->setField('id');

        
        $action_group = new TDataGridActionGroup('Options', 'bs:th');
        $action_group->addHeader('Options');
        $action_group->addAction($edit_action );
        $action_group->addAction($delete_action);
        $action_group->addSeparator();
        $action_group->addAction($telefone_action);
        $action_group->addAction($email_action);
        
         
        // add the actions to the datagrid
        $this->datagrid->addActionGroup($action_group);
        
     
        // create the datagrid model
        $this->datagrid->createModel();
        
        // create the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());
        
        // create the page container
        $container = TVBox::pack( $this->form, $this->datagrid, $this->pageNavigation);
        parent::add($container);
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
