<?php
/**
* ClienteList Listing
* @author  Alexandre
*/
class ClienteList extends Controller
{
  protected $form;     // registration form
  protected $datagrid; // listing
  protected $pageNavigation;
  protected $formgrid;
  protected $deleteButton;
  protected $transformCallback;

  /**
  * Page constructor
  */
  public function __construct()
  {
    parent::__construct();

    parent::setDatabase('sample');            // defines the database
    parent::setActiveRecord('Cliente');   // defines the active record
    parent::setDefaultOrder('id', 'asc');         // defines the default order
    // parent::setCriteria($criteria) // define a standard filter

    parent::addFilterField('nome', 'like', 'nome'); // filterField, operator, formField

    // creates the form
    $this->form = new TQuickForm('form_search_Cliente');
    $this->form->class = 'tform'; // change CSS class
    $this->form = new BootstrapFormWrapper($this->form);
    $this->form->style = 'display: table;width:100%'; // change style
    $this->form->setFormTitle('Cliente');


    // create the form fields
    $nome = new TEntry('nome');


    // add the fields
    $this->form->addQuickField('Nome', $nome,  200 );


    // keep the form filled during navigation with session data
    $this->form->setData( TSession::getValue('Cliente_filter_data') );

    // add the search form actions
    $this->form->addQuickAction(_t('Find'), new TAction(array($this, 'onSearch')), 'fa:search');
    $this->form->addQuickAction(_t('New'),  new TAction(array('ClienteForm', 'onEdit')), 'bs:plus-sign green');

    // creates a DataGrid
    $this->datagrid = new TDataGrid;
    $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
    $this->datagrid->style = 'width: 100%';
    $this->datagrid->setHeight(320);
    // $this->datagrid->datatable = 'true';
    // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');


    // creates the datagrid columns
    $column_check = new TDataGridColumn('check', '', 'center');
    $column_id = new TDataGridColumn('id', 'Id', 'right');
    $column_nome = new TDataGridColumn('nome', 'Nome', 'left');


    // add the columns to the DataGrid
    $this->datagrid->addColumn($column_check);
    $this->datagrid->addColumn($column_id);
    $this->datagrid->addColumn($column_nome);


    // create EDIT action
    $action_edit = new TDataGridAction(array('ClienteForm', 'onEdit'));
    $action_edit->setUseButton(TRUE);
    $action_edit->setButtonClass('btn btn-default');
    $action_edit->setLabel(_t('Edit'));
    $action_edit->setImage('fa:pencil-square-o blue fa-lg');
    $action_edit->setField('id');
    $action_edit->setDisplayCondition(array($this,'checkEdit'));
    $this->datagrid->addAction($action_edit);

    // create DELETE action
    $action_del = new TDataGridAction(array($this, 'onDelete'));
    $action_del->setUseButton(TRUE);
    $action_del->setButtonClass('btn btn-default');
    $action_del->setLabel(_t('Delete'));
    $action_del->setImage('fa:trash-o red fa-lg');
    $action_del->setField('id');
    $action_del->setDisplayCondition(array($this,'checkDelete'));
    $this->datagrid->addAction($action_del);

    $telefone_action = new TDataGridAction(array('telefoneList', 'onReload'));
    $telefone_action->setLabel('Telefones');
    $telefone_action->setImage('bs:search blue');
    $telefone_action->setField('id');
    $this->datagrid->addAction($telefone_action);

    $email_action = new TDataGridAction(array('emailList', 'onReload'));
    $email_action->setLabel('Email');
    $email_action->setImage('bs:search blue');
    $email_action->setField('id');
    $this->datagrid->addAction($email_action);


    // create the datagrid model
    $this->datagrid->createModel();

    // create the page navigation
    $this->pageNavigation = new TPageNavigation;
    $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
    $this->pageNavigation->setWidth($this->datagrid->getWidth());

    $this->datagrid->disableDefaultClick();

    // put datagrid inside a form
    $this->formgrid = new TForm;
    $this->formgrid->add($this->datagrid);

    // creates the delete collection button
    $this->deleteButton = new TButton('delete_collection');
    $this->deleteButton->setAction(new TAction(array($this, 'onDeleteCollection')), AdiantiCoreTranslator::translate('Delete selected'));
    $this->deleteButton->setImage('fa:remove red');
    $this->formgrid->addField($this->deleteButton);

    $gridpack = new TVBox;
    $gridpack->style = 'width: 100%';
    $gridpack->add($this->formgrid);
    $gridpack->add($this->deleteButton)->style = 'background:whiteSmoke;border:1px solid #cccccc; padding: 3px;padding: 5px;';

    $this->transformCallback = array($this, 'onBeforeLoad');


    // vertical box container
    $container = new TVBox;
    $container->style = 'width: 90%';
    // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
    $container->add(TPanelGroup::pack('Title', $this->form));
    $container->add($gridpack);
    $container->add($this->pageNavigation);

    parent::add($container);
  }

  /**
  * Transform datagrid objects
  * Create the checkbutton as datagrid element
  */
  public function onBeforeLoad($objects, $param)
  {
    // update the action parameters to pass the current page to action
    // without this, the action will only work for the first page
    $deleteAction = $this->deleteButton->getAction();
    $deleteAction->setParameters($param); // important!

    $gridfields = array( $this->deleteButton );

    foreach ($objects as $object)
    {
      $object->check = new TCheckButton('check' . $object->id);
      $object->check->setIndexValue('on');
      $gridfields[] = $object->check; // important
    }

    $this->formgrid->setFields($gridfields);
  }

}
