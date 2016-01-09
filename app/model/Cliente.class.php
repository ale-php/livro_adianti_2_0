<?php
/**
* Clientes Active Record
* @author Alexandre
*/
class Cliente extends TRecord
{
  const TABLENAME = 'clientes';
  const PRIMARYKEY= 'id';
  const IDPOLICY = 'max'; // {max, serial}

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
//method novo que dispara antes de carregar
public function onBeforeLoad($id)
  {
    $this->telefones = parent::loadComposite('telefone', 'clientes_id', $id);
    $this->emails = parent::loadComposite('email', 'clientes_id', $id);
  }

  //method novo que dispara antes de salvar
  public function onAfterStore($object)
  {
  

    parent::saveComposite('telefone', 'clientes_id', $object->id, $this->telefones);
    parent::saveComposite('email', 'clientes_id', $object->id, $this->emails);
    
 
    return $object;
  }

  //method novo que dispara antes de deletar
 public function onBeforeDelete($object)
{

  parent::deleteComposite('telefone', 'clientes_id', $object->id);
  parent::deleteComposite('email', 'clientes_id', $object->id);

 return $object;
 }
 


}
?>
