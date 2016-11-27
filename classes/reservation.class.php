<?php

class reservation
{
	//	internal variables
	
	private $_id ;
	private $_idPatient ;
	private $_nomPatient ;
	private $_idEleve ;
	private $_nomEleve ;
	private $_idPatho ;
	private $_enregistrement ;
	private $_confirme ;

	// Accesseurs
	
	public function id() 			{ return $this->_id ; }
	public function idPatient() 		{ return $this->_idPatient ; }
	public function idEleve() 		{ return $this->_idEleve  ; }
	public function idPatho() 		{ return $this->_idPatho  ; }
	public function nomPatient() 		{ return $this->_nomPatient ; }
	public function nomEleve() 		{ return $this->_nomEleve  ; }
	public function enregistrement() 	{ return $this->_enregistrement ; }
	public function confirme() 		{ return $this->_confirme ; }
	
	
	// Setters
	
	public function setId($id) 			{ $this->_id = ( intval($id) > 0 ) ? $id : null; }
	public function setIdPatient($id) 		{ $this->_idPatient = ( intval($id) > 0 ) ? $id : null ;}
	public function setIdEleve($id) 		{ $this->_idEleve = ( intval($id) > 0 ) ? $id : null ;}
	public function setIdPatho($id) 		{ $this->_idPatho = intval($id) ;}
	public function setNomEleve($v) 		{ $this->_nomEleve = $v ;}
	public function setNomPatient($v) 		{ $this->_nomPatient = $v ;}
	public function setEnregistrement($v) 		{ $this->_enregistrement = $v ;}
	public function setConfirme($v) 		{ $this->_confirme = ( $v == true )		? 1	: 0	; }
	
	public function hydrate(array $donnees)
	{
		//show($donnees);
		foreach ($donnees as $key => $value)
		{
			// On récupère le nom du setter correspondant à l'attribut.
			$method = 'set'.ucfirst($key);
			//echo $method ;
			// Si le setter correspondant existe.
			if (method_exists($this, $method))
			{
				// On appelle le setter.
				$this->$method($value);
				//echo ' - ' . $value ;
			}
			//echo '<br/>' ;
		}
	}
	// ...
	
	//	Constructor
	function __construct (array $datas)
	{
		$this->hydrate($datas) ;
	}

}

