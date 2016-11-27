<?php

class eleve
{
	//	internal variables
	
	private $_id ;
	private $_nom ;
	private $_prenom ;
	private $_matricule ;
	private $_motDePasse ;
	private $_annee ;
	private $_email ;
	private $_telephone ;
	private $_statut ;
	private $_soins ;


	// Accesseurs
	
	public function id() 		{ return $this->_id ; }
	public function nom()		{ return $this->_nom ; }
	public function prenom()	{ return $this->_prenom ; }
	public function matricule()	{ return $this->_matricule ; }
	public function motDePasse(){ return $this->_motDePasse ; }
	public function annee()		{ return $this->_annee ; }
	public function email()		{ return $this->_email ; }
	public function telephone()	{ return $this->_telephone ; }
	public function statut()	{ return $this->_statut ; }
	public function soins()		{ return $this->_soins ; }
	
	public function isAdmin()	{ return ( $this->_statut == 'administrateur' ) ? true : false ; }
	
	
	// Setters
	
	public function setId($id) 				{ $this->_id = (int) $id ; }
	public function setNom($nom)			{ $this->_nom = $nom ; }
	public function setPrenom($prenom)		{ $this->_prenom = $prenom ; }
	public function setMatricule($matricule) {$this->_matricule = $matricule ; }
	public function setMotDePasse($motDePasse) {$this->_motDePasse = $motDePasse ; }
	public function setAnnee($annee)		{ $this->_annee = $annee ; }
	public function setEmail($email)		{ $this->_email = $email ; }
	public function setTelephone($tel)		{ $this->_telephone = $tel ; }
	public function setStatut($statut)		{ $this->_statut = $statut ; }
	public function setSoins($nbSoins)		{ $this->_soins = (int) $nbSoins ; }
	
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
	function __construct ( array $datas)
	{
		$this->hydrate($datas) ;
	}

}

