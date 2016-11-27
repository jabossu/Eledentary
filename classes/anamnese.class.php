<?php

class anamnese
{
	//	internal variables
	
	private $_id ;
	private $_id_patient ;
	private $_texte ;
	private $_id_patho ;

	// Accesseurs
	
	public function id() 		{ return $this->_id ; }
	public function id_patient()	{ return $this->_id_patient ; }
	public function texte()		{ return $this->_texte ; }
	public function id_patho()	{ return $this->_id_patho ; }
		

	// Setters
	
	public function setId($v) 				{ $this->_id = $v ; }
	public function setId_patient($v) 			{ $this->_id_patient = 		( is_int( $v ) )	? $v	: null	; }
	public function setTexte($v) 				{ $this->_texte = $v ; } 
	public function setId_patho($v) 			{ $this->_id_patho = 		( is_int( $v ) )	? $v	: null	; }
	
	
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
/**/
}

