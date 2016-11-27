<?php

class chat
{
	//	internal variables
	
	private $_id ;
	private $_userid ;
	private $_time ;
	private $_day ;
	private $_message ;
	private $_username ;
	private $_anneeuser ;

	// Accesseurs
	public function id() 				{ return $this->_id ; }
	public function userid() 			{ return $this->_userid ; }
	public function time() 				{ return $this->_time ; }
	public function day() 				{ return $this->_day ; }
	public function message() 			{ return $this->_message ; }
	public function username()			{ return $this->_username ; }
	public function anneeuser()			{ return $this->_anneeuser ; }
	
	
	// Setters

	public function setId($id) 				{ $this->_id = (int) $id ; }
	public function setUserid($v) 			{ $this->_userid = $v ; }
	public function setTime($v) 			{ $this->_time = $v ; }
	public function setDay($v) 				{ $this->_day = $v ; }
	public function setUsername($v) 		{ $this->_username = $v ; }
	public function setMessage($v) 			{ $this->_message = $v ; }
	public function setAnneeuser($v) 		{ $this->_anneeuser = $v ; }
	
	
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

