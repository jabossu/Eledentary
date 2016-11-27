<?php

class logentry
{
	//	internal variables

	private $_id ;
	private $_ipaddress ;
	private $_timestamp ;
	private $_date ;
	private $_year ;
	private $_month ;
	private $_day ;
	private $_hour ;
	private $_action ;
	private $_iduser ;
	private $_nuser ;
	private $_puser ;
	private $_details ;

	// Accesseurs	
	public function id() 			{ return $this->_id ; }
	public function ipaddress()		{ return $this->_ipaddress ; }
	public function timestamp() 	{ return $this->_timestamp ; }
	public function date() 			{ return $this->_date ; }
	public function year() 			{ return $this->_year ; }
	public function month() 		{ return $this->_month ; }
	public function day() 			{ return $this->_day ; }
	public function hour() 			{ return $this->_hour ; }
	public function action() 		{ return $this->_action ; }
	public function iduser() 		{ return $this->_iduser ; }
	public function nuser() 		{ return $this->_nuser ; }
	public function puser() 		{ return $this->_puser ; }
	public function details() 		{ return $this->_details ; }
	
	public function print_l()
	{
		echo '<b>' . $this->date() . '</b> : User <a href="/?page=profile&id=' . $this->iduser() . '">' . $this->puser() . ' ' . $this->nuser() . '</a> [@<u>' . $this->ipaddress() . '</u>] - ' . $this->action() . ' | ' . $this->details() ;
	}
	
	
	// Setters	
	public function setId($id) 				{ $this->_id = (int) $id ; }
	public function setTimestamp($v) 		{ $this->_timestamp = $v ; }
	public function setIpaddress($v) 		{ $this->_ipaddress = $v ; }
	public function setDate($v) 			{ $this->_date = $v ; }
	public function setYear($v) 			{ $this->_year = $v ; }
	public function setMonth($v)	 		{ $this->_month = $v ; }
	public function setDay($v) 				{ $this->_day = $v ; }
	public function setHour($v) 			{ $this->_hour = $v ; }
	public function setAction($v)	 		{ $this->_action = $v ; }
	public function setIduser($v) 			{ $this->_iduser = (int) $v ; }
	public function setNuser($v) 			{ $this->_nuser = $v ; }
	public function setPuser($v) 			{ $this->_puser = $v ; }
	public function setDetails($v) 			{ $this->_details = $v ; }

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

