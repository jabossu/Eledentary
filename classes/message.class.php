<?php

class message
{
	//	internal variables
	private $_id ;
	private $_timestamp ;
	private $_jour ;
	private $_date ;
	private $_objet ;
	private $_corps ;
	private $_expediteur ;
	private $_etat ;
	private $_nom ;
	private $_prenom ;
	private $_email ;

	// Accesseurs
	public function id() 				{ return $this->_id ; }
	public function timestamp()			{ return $this->_timestamp ; }
	public function jour()				{ return $this->_jour ; }
	public function date()				{ return $this->_date ; }
	public function objet() 			{ return $this->_objet ; }
	public function corps() 			{ return $this->_corps ; }
	public function expediteur() 		{ return $this->_expediteur ; }
	public function etat() 				{ return $this->_etat ; }
	public function nom() 				{ return $this->_nom ; }
	public function prenom() 			{ return $this->_prenom ; }
	public function email() 			{ return $this->_email ; }
	
	
	// Setters
	public function setId($id) 					{ $this->_id	= (int) $id ; }
	public function setTimestamp($timestamp)	{ $this->_timestamp	= $timestamp ; }
	public function setJour($jour)				{ $this->_jour	= $jour ; }
	public function setDate($date)				{ $this->_date	= $date ; }
	public function setObjet($objet) 			{ $this->_objet	= $objet ; }
	public function setCorps($corps) 			{ $this->_corps	= $corps ; }
	public function setExpediteur($expediteur) 	{ $this->_expediteur = $expediteur ; }
	public function setEtat($etat) 				{ $this->_etat = $etat ; }
	public function setNom($nom) 				{ $this->_nom = $nom ; }
	public function setPrenom($prenom) 			{ $this->_prenom = $prenom ; }
	public function setEmail($email) 			{ $this->_email = $email ; }
	
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

}

