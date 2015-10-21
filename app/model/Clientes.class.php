<?php
/**
 * Clientes Active Record
 * @author  Alexandre 
 */
class Clientes extends TRecord
{
    const TABLENAME = 'clientes';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    private $telefones;
    private $emails;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
    }

    
    /**
     * Method addtelefone
     * Add a telefone to the Clientes
     * @param $object Instance of telefone
     */
    public function addtelefone(telefone $object)
    {
        $this->telefones[] = $object;
    }
    
    /**
     * Method gettelefones
     * Return the Clientes' telefone's
     * @return Collection of telefone
     */
    public function gettelefones()
    {
        return $this->telefones;
    }
    
    /**
     * Method addemail
     * Add a email to the Clientes
     * @param $object Instance of email
     */
    public function addemail(email $object)
    {
        $this->emails[] = $object;
    }
    
    /**
     * Method getemails
     * Return the Clientes' email's
     * @return Collection of email
     */
    public function getemails()
    {
        return $this->emails;
    }

    /**
     * Reset aggregates
     */
    public function clearParts()
    {
        $this->telefones = array();
        $this->emails = array();
    }

    /**
     * Load the object and its aggregates
     * @param $id object ID
     */
    public function load($id)
    {
        $this->telefones = parent::loadComposite('telefone', 'clientes_id', $id);
        $this->emails = parent::loadComposite('email', 'clientes_id', $id);
    
        // load the object itself
        return parent::load($id);
    }

    /**
     * Store the object and its aggregates
     */
    public function store()
    {
        // store the object itself
        parent::store();
    
        parent::saveComposite('telefone', 'clientes_id', $this->id, $this->telefones);
        parent::saveComposite('email', 'clientes_id', $this->id, $this->emails);
    }

    /**
     * Delete the object and its aggregates
     * @param $id object ID
     */
    public function delete($id = NULL)
    {
        $id = isset($id) ? $id : $this->id;
        parent::deleteComposite('telefone', 'clientes_id', $id);
        parent::deleteComposite('email', 'clientes_id', $id);
    
        // delete the object itself
        parent::delete($id);
    }


}
