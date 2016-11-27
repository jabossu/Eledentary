<?php

class article
{
	//	internal variables
	
	private $_id ;
	private $_date ;
	private $_fr_titre ;
	private $_fr_contenu ;
	private $_en_titre ;
	private $_en_contenu ;

	// Accesseurs
	
	public function id() 		{ return $this->_id ; } // Renvoie l'ID de l'article
	public function date()
	// Renvoie la date de l'article sous forme JOUR MOIS ANNEE
	{
		//$m, $d, $y = explode( '-', $this->date() ) ;
		//$date = strtotime( $this->date() ) ;
		return  date('d M Y', strtotime( $this->_date ) )  ;
	}
	public function titre($l='fr_FR')
	//Renvoie le titre en anglais de l'article 
	{
		if ( $l == 'en_EN' )
		{	return $this->_en_titre ;	}
		else
		{	return $this->_fr_titre ;		}
	
	}
	public function contenu($l='fr_FR')
	//Renvoie le titre en francais de l'article
	{
		if ( $l == 'en_EN' )
		{	return $this->_en_contenu ;	}
		else
		{	return $this->_fr_contenu ;		}
	
	}
	
	
	// Setters
	// Remplit les differents atttributs
	
	public function setId($id) 		{ $this->_id = (int) $id ; }
	public function setDate($date) 		{ $this->_date = $date ; }
	public function setFr_titre($texte) 	{ $this->_fr_titre = $texte ; }
	public function setFr_contenu($texte) 	{ $this->_fr_contenu = $texte ; }
	public function setEn_titre($texte) 	{ $this->_en_titre = $texte ; }
	public function setEn_contenu($texte) 	{ $this->_en_contenu = $texte ; }
	
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

