
<?php
/**
* email Active Record
* @author Alexandre
*/
class email extends TRecord
{
const TABLENAME = 'email';
const PRIMARYKEY= 'id';
const IDPOLICY = 'max'; // {max, serial}
/**

* Constructor method
*/
public function __construct($id = NULL, $callObjectLoad = TRUE)
{
parent::__construct($id, $callObjectLoad);
parent::addAttribute('email');
parent::addAttribute('clientes_id');
}
}

?>
