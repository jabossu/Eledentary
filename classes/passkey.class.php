<?php

class passkey
{
	//	internal variables
	
	private $_id ;
	private $_userid ;
	private $_value ;
	private $_date ;

	// Accesseurs
	
	public function id() 		{ return $this->_id ; }
	public function userid() 	{ return $this->_userid ; }
	public function value() 	{ return $this->_value ; }
	public function date() 		{ return $this->_date ; }
	
	
	// Setters
	
	public function setUserid($userid) 		{ $this->_userid = (int) $userid ; }
	public function setId($id) 				{ $this->_id = (int) $id ; }
	public function setValue($v) 			{ $this->_value = $v ; }
	public function setDate($d) 				{ $this->_date = $d ; }
	
	public function hydrate(array $donnees)
	{
		foreach ($donnees as $key => $value)
		{
			// On récupère le nom du setter correspondant à l'attribut.
			$method = 'set'.ucfirst($key);
			
			// Si le setter correspondant existe.
			if (method_exists($this, $method))
			{
				// On appelle le setter.
				$this->$method($value);
			}
		}
	}
	// ...
	
	//	Constructor
	function __construct (array $datas)
	{
		$this->hydrate($datas) ;
	}

}

