<?php
/**
 * Receita Active Record
 * @author  <your-name-here>
 */
class Receita extends TRecord
{
    const TABLENAME = 'receita';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    private $cliente;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
        parent::addAttribute('valor');
        parent::addAttribute('vencimento');
        parent::addAttribute('cliente_id');
    }

    
    /**
     * Method set_cliente
     * Sample of usage: $receita->cliente = $object;
     * @param $object Instance of Cliente
     */
    public function set_cliente(Cliente $object)
    {
        $this->cliente = $object;
        $this->cliente_id = $object->id;
    }
    
    /**
     * Method get_cliente
     * Sample of usage: $receita->cliente->attribute;
     * @returns Cliente instance
     */
    public function get_cliente()
    {
        // loads the associated object
        if (empty($this->cliente))
            $this->cliente = new Cliente($this->cliente_id);
    
        // returns the associated object
        return $this->cliente;
    }
    


}
