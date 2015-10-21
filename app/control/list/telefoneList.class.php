<?php
/**
 * telefoneList Listing
 * @author  Alexandre
 */
class telefoneList extends TWindow
{
 
    private $datagrid; // listing

    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct()
    {
        parent::__construct();
        parent::setTitle('Telefones');
        parent::setSize(500,400);
        parent::setModal(true);

        //checa para verificar se esta logado
        Usuario::checkLogin();
        //verifica o nivel de usuario que pode acessar
        Usuario::acesso(3);

      
        
        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->setHeight(320);
        

        // creates the datagrid columns
        $id   = new TDataGridColumn('id', 'id', 'right', 100);
        $numero   = new TDataGridColumn('numero', 'numero', 'left', 200);
        $clientes_id   = new TDataGridColumn('clientes->nome', 'clientes', 'right', 100);


        // add the columns to the DataGrid
        $this->datagrid->addColumn($id);
        $this->datagrid->addColumn($numero);
        $this->datagrid->addColumn($clientes_id);

     
        
        $action2 = new TDataGridAction(array($this, 'onDelete'));
        $action2->setLabel(_t('Delete'));
        $action2->setImage('ico_delete.png');
        $action2->setField('id');
        
        // add the actions to the datagrid
     
        $this->datagrid->addAction($action2);
        
        // create the datagrid model
        $this->datagrid->createModel();
        
      
        
        // create the page container
        $container = TVBox::pack( $this->datagrid, $this->pageNavigation);
        parent::add($container);
    }
    
    
    /**
     * method onReload()
     * Load the datagrid with the database objects
     */
    function onReload($param = NULL)
    {
        try
        {
            // open a transaction with database 'sample'
            TTransaction::open('sample');
            
            // creates a repository for telefone
            $repository = new TRepository('telefone');
            $limit = 10;
            // creates a criteria
            $criteria = new TCriteria;
            //cria filtro para mostrar os telefones apenas de um cliente
            $filter =  new TFilter('clientes_id','=',$param['key']);
            $criteria->add($filter);
            // default order
            if (empty($param['order']))
            {
                $param['order'] = 'id';
                $param['direction'] = 'asc';
            }
            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $limit);
            

            if (TSession::getValue('telefoneList_filter_clientes_id')) {
                $criteria->add(TSession::getValue('telefoneList_filter_clientes_id')); // add the session filter
            }



            
            // load the objects according to criteria
            $objects = $repository->load($criteria, FALSE);
            
            $this->datagrid->clear();
            if ($objects)
            {
                // iterate the collection of active records
                foreach ($objects as $object)
                {
                    // add the object inside the datagrid
                    $this->datagrid->addItem($object);
                }
            }
            
        
            // close the transaction
            TTransaction::close();
         
        }
        catch (Exception $e) // in case of exception
        {
            // shows the exception error message
            new TMessage('error', '<b>Error</b> ' . $e->getMessage());
            
            // undo all pending operations
            TTransaction::rollback();
        }
    }
    
    /**
     * method onDelete()
     * executed whenever the user clicks at the delete button
     * Ask if the user really wants to delete the record
     */
    function onDelete($param)
    {
        // define the delete action
        $action = new TAction(array($this, 'Delete'));
        $action->setParameters($param); // pass the key parameter ahead
        
        // shows a dialog to the user
        new TQuestion(TAdiantiCoreTranslator::translate('Do you really want to delete ?'), $action);
    }
    
    /**
     * method Delete()
     * Delete a record
     */
    function Delete($param)
    {
        try
        {
            $key=$param['key']; // get the parameter $key
            TTransaction::open('sample'); // open a transaction with database
            $object = new telefone($key, FALSE); // instantiates the Active Record
            $object->delete(); // deletes the object from the database
            TTransaction::close(); // close the transaction
            $this->onReload( $param ); // reload the listing
            new TMessage('info', TAdiantiCoreTranslator::translate('Record deleted')); // success message
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', '<b>Error</b> ' . $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }

    public function checkDelete(){

        $valor = Usuario::permissao(5);
        return $valor;
    }
    
    /**
     * method show()
     * Shows the page
     */
    function show()
    {
        // check if the datagrid is already loaded
      
            $this->onReload( func_get_arg(0) );
        
        parent::show();
    }
}
