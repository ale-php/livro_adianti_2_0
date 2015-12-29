<?php
/**
 * Despesa Active Record
 * @author  <your-name-here>
 */
class Despesa extends TRecord
{
    const TABLENAME = 'despesa';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    private $fornecedor;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
        parent::addAttribute('valor');
        parent::addAttribute('vencimento');
        parent::addAttribute('fornecedor_id');
    }

    
    /**
     * Method set_fornecedor
     * Sample of usage: $despesa->fornecedor = $object;
     * @param $object Instance of Fornecedor
     */
    public function set_fornecedor(Fornecedor $object)
    {
        $this->fornecedor = $object;
        $this->fornecedor_id = $object->id;
    }
    
    /**
     * Method get_fornecedor
     * Sample of usage: $despesa->fornecedor->attribute;
     * @returns Fornecedor instance
     */
    public function get_fornecedor()
    {
        // loads the associated object
        if (empty($this->fornecedor))
            $this->fornecedor = new Fornecedor($this->fornecedor_id);
    
        // returns the associated object
        return $this->fornecedor;
    }
    


}
