<?php

class siteconfig
{
	//	internal variables
	private $_websiteTitle ;
	private $_websiteMoto ;
	private $_websiteFooter ;
	
	private $_websiteLanguage ;
	
	private $_allowRegister ;
	private $_bypassApproval ;
	private $_allowAnamneses ;
	
	private $_patientLimit ;

	// Accesseurs
	
	public function websiteTitle() 		{ return $this->_websiteTitle ; }
	public function websiteMoto() 		{ return $this->_websiteMoto ; }
	public function websiteFooter() 	{ return $this->_websiteFooter ; }
	public function websiteLanguage() 	{ return $this->_websiteLanguage ; }
	public function allowRegister() 	{ return ( $this->_allowRegister == 'on' ) ? 'on' : 'off' ; }
	public function bypassApproval() 	{ return ( $this->_bypassApproval == 'on' ) ? 'on' : 'off' ; }
	public function allowAnamneses() 	{ return ( $this->_allowAnamneses == 'on' ) ? 'on' : 'off' ; }
	public function patientLimit() 		{ return $this->_patientLimit ; }

	
	
	// Setters
	
	public function setWebsiteTitle($v) 
	{
		$this->_websiteTitle = strip_tags($v) ;
	}
	
	public function setWebsiteMoto($v) 	{ $this->_websiteMoto = strip_tags($v) ; }
	public function setWebsiteFooter($v) 	{ $this->_websiteFooter = $v ;}
	public function setWebsiteLanguage($v) 
	{
		if ( preg_match("#^[a-z]{2}_[A-Z]{2}$#", $v) )
		{
			$this->_websiteLanguage = $v ;
		}
	}
	public function setAllowRegister($v) 
	{
		$this->_allowRegister = ( $v == 'on' ) ? 'on' : 'off'  ;
	}
	public function setBypassApproval($v) 
	{
		$this->_bypassApproval = ( $v == 'on' ) ? 'on' : 'off'  ;
}
	public function setAllowAnamneses($v) 
	{
		$this->_allowAnamneses = ( $v == 'on' ) ? 'on'  : 'off'  ;
	}
	public function setPatientLimit($v) 
	{
		$v = (int) $v ;
		$this->_patientLimit = ( $v >= 1 ) ? $v : 1 ;
	}
	
	
	
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

