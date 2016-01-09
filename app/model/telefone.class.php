<?php
/**
* telefone Active Record
* @author Alexandre
*/
class telefone extends TRecord
{
const TABLENAME = 'telefone';
const PRIMARYKEY= 'id';
const IDPOLICY = 'max'; // {max, serial}
/**
* Constructor method
*/
public function __construct($id = NULL, $callObjectLoad = TRUE)
{
parent::__construct($id, $callObjectLoad);
parent::addAttribute('numero');
parent::addAttribute('clientes_id');
}
}