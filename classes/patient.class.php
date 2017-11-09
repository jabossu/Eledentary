<?php

class patient
{
	//	internal variables
	
	private $_id ;
	private $_cnp ;
	private $_nom ;
	private $_prenom ;
	private $_id_patho ;
	private $_patho ;
	private $_dent ;
	private $_details ;
	private $_email ;
	private $_telephone ;
	private $_addresse ;
	private $_soignant ;
	private $_annees ;

	// Accesseurs
	
	public function id() 		{ return $this->_id ; }
	public function cnp()		{ return $this->_cnp ; }
	public function nom()		{ return $this->_nom ; }
	public function prenom()	{ return $this->_prenom ; }
	public function id_patho()	{ return $this->_id_patho ; }
	public function patho()		{ return $this->_patho ; }
	public function p_dent()	{ return $this->_dent ; }
	public function annees()	{ return $this->_annees ; }
	public function dent()		
	{
		$str = ( $this->_dent >= 50 ) ? '(Childish)' : '' ;
		$nom = intval( substr($this->_dent, 1, 1) );
		$str .= ' ' ;
		switch ($nom)
		{
			case 1:
				$str .= 'incisive 1';
				break;
			
			case 2:
				$str .= 'incisive 2';
				break;
			
			case 3:
				$str .= 'canine';
				break;
			
			case 4:
				$str .= ( $this->_dent >= 50 )	? 'molaire'	: 'premolaire'	;
				$str .= ' 1';
				break;
				
			case 5:
				$str .= ( $this->_dent >= 50 )	? 'molaire'	: 'premolaire'	;
				$str .= ' 2';
				break;
				
			case 6:
				$str .= 'molaire 1';
				break;
			
			case 7:
				$str .= 'molaire 2';
				break;
				
			case 8:
				$str .= 'molaire 3';
				break;
		}
		$arcade = intval( substr($this->_dent, 0, 1) );
		$str .= ' ' ;
		switch ($arcade)
		{
			case 1:
			case 5:
				$str .= 'Sup. right' ;
			break;
			
			case 2:
			case 6:
				$str .= 'Sup. left' ;
			break;
			
			case 3:
			case 7:
				$str .= 'Inf. left' ;
			break;
			
			case 4:
			case 8:
				$str .= 'Inf. Right' ;
			break;
		}
		return $str ;
	}
	public function details()	{ return $this->_details ; }
	public function email()		{ return $this->_email ; }
	public function telephone()	{ return $this->_telephone ; }
	public function addresse()	{ return $this->_addresse ; }
	public function soignant()	{ return $this->_soignant ; }
	

	// Setters
	
	public function setId($v) 				{ $this->_id = $v ; }
	public function setCnp($v) 				{ $this->_cnp = 		( preg_match('#^[0-9]{13}$#', $v )	)	? $v	: null	; }
	public function setNom($v) 				{ $this->_nom = 		( preg_match('#^[a-z -]{2,}$#i', $v ) )		? strtoupper($v)	: null	;	}
	public function setPrenom($v) 			{ $this->_prenom = 		( preg_match('#^[a-z -]{3,}$#i', $v ) )		? strtoupper($v)	: null	; 	}
	public function setId_patho($v) 		{ $this->_id_patho = 	( intval($v) > 0 )		? $v	: null	; }
	public function setDent($v) 			{ $this->_dent = 		( preg_match('#^([1-4][1-8]|[5-8][1-5])$#', $v ) )			? $v	: '0'	; }
	public function setPatho($v) 			{ $this->_patho = $v ; }
	public function setDetails($v) 			{ $this->_details = $v ; }
	public function setAnnees($v) 			{ $this->_annees = $v ; }
	public function setEmail($v) 			{ $this->_email = 		(preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', $v) ) ? $v : null; }
	public function setTelephone($v) 		{ $this->_telephone	=	(preg_match('#^(0|\+40)[-. ]?7[0-9]{2}([-. ]?[0-9]{3}){2}$#', $v) ) ? $v : null; }
	public function setAddresse($v) 		{ $this->_addresse = ( $v != '---' )		? $v	: null	; ; }
	public function setSoignant($v) 		{ $this->_soignant = 	( $v != 0 )		? $v	: null	; }
	
	
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
	
	//	Constructor
	function __construct (array $datas)
	{
		$this->hydrate($datas) ;
	}
/**/
}

