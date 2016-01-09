<?php
/**
 * ClienteForm Form
 * @author  <your name here>
 */
class ClienteForm extends TWindow
{
    protected $form; // form
    
    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();
        
        // creates the form
        $this->form = new TForm('form_Cliente');
        $this->form->class = 'tform'; // change CSS class
        
        $note = new TNotebook(400,300);
        // add a table inside form
        $table = new TTable;
        $table-> width = '100%';
        // add a row for the form title
        $row = $table->addRow();
        $row->class = 'tformtitle'; // CSS class
        $row->addCell( new TLabel('Clientes') )->colspan = 2;




        // create the form fields
        $id = new TEntry('id');
        $nome = new TEntry('nome');


       // campo para telefones
    $multifield = new TMultiField('telefone');
    $telefone_id = new TEntry('id');
    $telefone_id->setEditable(false);
    $telefone = new TEntry('numero');
    $telefone->setMask('(99)99999-9999');
    //    campo para emails
    $multifield_email = new TMultiField('email');
    $email = new TEntry('email');
    $email_id = new TEntry('id');
    $email->addValidation('email', new TEmailValidator);
    $multifield->addField('id','Codigo',$telefone_id,200);
    $multifield->addField('numero','Telefone',$telefone,200,true);
    $multifield_email->addField('id','Codigo',$email_id,200);
    $multifield_email->addField('email','Email',$email,200,true);
    // define the sizes
    $id->setSize(100);
    $nome->setSize(200);
    // add one row for each form field
    $table->addRowSet( new TLabel('id:'), $id );
    $table->addRowSet( new TLabel('nome:'), $nome );
    $this->form->setFields(array($id,$nome,$multifield,$multifield_email));
    // create the form actions
    $save_button = TButton::create('save', array($this, 'onSave'), _t('Save'),'bs:floppy-disk red');
    $new_button = TButton::create('new', array($this, 'onEdit'), _t('New') ,'bs:edit green');
    $this->form->addField($save_button);
    $this->form->addField($new_button);
    
    
        $buttons_box = new THBox;
    $buttons_box->add($save_button);
    $buttons_box->add($new_button);
    // add a row for the form action
    $row = $table->addRow();
    $row->class = 'tformaction'; // CSS class
    $row->addCell($buttons_box)->colspan = 2;
    $note->appendPage('Clientes',$table);
    $note->appendPage('Telefone',$multifield);
    $note->appendPage('Email',$multifield_email);
    $this->form->add($note);
    


        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add(TPanelGroup::pack('Title', $this->form));
        
        parent::add($container);
    }

    /**
     * Save form data
     * @param $param Request
     */
    public function onSave( $param )
    {
    try
    {        
        TTransaction::open('sample'); // open a transaction
        // get the form data into an active record Clientes
        $object = $this->form->getData('Cliente');
        if($object->telefone){
        foreach($object->telefone as $tell):
        $telefone = new telefone();
        $telefone->numero = $tell->numero;
        $object->addtelefone($telefone);
        endforeach;
   
    }
         if($object->email){
        foreach($object->email as $mail):
        $email = new email();
        $email->email = $mail->email;
        $object->addemail($email);
        endforeach;
        }
        $this->form->validate(); // form validation
        $object->store();
        $this->form->setData($object); // keep form data
        TTransaction::close(); // close the transaction
        // shows the success message
        new TMessage('info', TAdiantiCoreTranslator::translate('Record saved'));
        }
        catch (Exception $e) // in case of exception
        {
        new TMessage('error', '<b>Error</b> ' . $e->getMessage()); // shows    the exception error message
        $this->form->setData( $this->form->getData() ); // keep form data
        TTransaction::rollback(); // undo all pending operations
        }
}
    
    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear( $param )
    {
        $this->form->clear();
    }
    
    /**
     * Load object to form data
     * @param $param Request
     */
    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
               $key=$param['key']; // get the parameter $key
                TTransaction::open('sample'); // open a transaction
                $object = new Clientes($key); // instantiates the Active Record
                $obj = new stdClass();
                $obj->id = $object->id;
                $obj->nome = $object->nome;
                // pega os telefones para edição
                $obj->telefone = $object->gettelefones();
                //pega os emails para edição
                $obj->email = $object->getemails();
                $this->form->setData($obj); // fill the form
                TTransaction::close(); // close the transaction
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }
}
