<?php
/**
 * email Active Record
 * @author  Alexandre
 */
class email extends TRecord
{
    const TABLENAME = 'email';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}

    private $clientes;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('email');
        parent::addAttribute('clientes_id');
    }

    public function get_clientes(){

        if(empty($this->clientes)){

            $this->clientes = new Clientes($this->clientes_id);
        }

        return $this->clientes;

    }

}
