<?php

class elevesManager
{
	
	//	internal variables
	private $_db ;
	private $_table ;
	
	//	Constructor
	public function __construct ($db)
	{
		$this->_db = $db;
		$this->_table = "eleves" ;
	}
	
	// ===================================
	//			Fonctions
	// ===================================
	
	public function genId()
	{
		do {	$id = uniqid();	  } 
		while ($this->idExiste($id));
		
		return $id;
	}
	
	public function add(eleve $eleve)
	{
		// Preparation
		$q = $this->_db->prepare("INSERT INTO :tablename SET
			id = :id, nom = :nom, prenom = :prenom, matricule = :matricule, motDepasse = :motDepasse, annee = :annee, email = :email, telephone = :telephone, statut = :statut, soins = :soins") ;
			
		$q->bindValue( ':tablename', $this->_db->prefix() . $this->_table) ;
		
		// Attribution des valeurs
		$q->bindValue(	':id'		,	$this->genId()			);
		$q->bindValue(	':nom'		,	$eleve->nom()			);
		$q->bindValue(	':prenom'	,	$eleve->prenom()		);
		$q->bindValue(	':motDepasse'	,	$eleve->motDePasse()	);
		$q->bindValue(	':matricule'	,	$eleve->matricule()		);
		$q->bindValue(	':annee'	,	$eleve->annee()			);
		$q->bindValue(	':email'	,	$eleve->email()			);
		$q->bindValue(	':telephone'	,	$eleve->telephone()		);
		$q->bindValue(	':statut'	,	'nouveau'		);
		$q->bindValue(	':soins'	,	0			);
		
		// Execution
		$q->execute() or die( print_r( $q->errorInfo() ) ) ;
	}
	
	function delete(eleve $e)
	{
		// Preparation
		$q = $this->_db->prepare("DELETE FROM :tablename	WHERE	id = :id") ;
		
		$q->bindValue( ':tablename', $this->_db->prefix() . $this->_table) ;
		
		// Attribution des valeurs
		$q->bindValue(':id', $e->id() );
		
		// Execution
		$q->execute() or die( print_r( $q->errorInfo() ) ) ;
		
		// Récupération
		$q->closeCursor() ;
	}

	public function hasPatients(eleve $e)
	{
		// Préparation
		$q = $this->_db->prepare('SELECT id FROM :tablename WHERE soignant = :id');
		$q->bindValue( ':tablename', $this->_db->prefix() . "patients") ;
		
		// Attribution des valeaurs
		$q->bindValue(	':id'	,	$e->id() ) ;
		// Execution
		$q->execute()  or die( print_r( $q->errorInfo() ) ) ;
		
		// Récupération
		$d = $q->fetch(PDO::FETCH_ASSOC) ;
		return ( $d == array() ) ? false : true ;
	}
	
	public function hasReserved(eleve $e)
	{
		// Préparation
		$q = $this->_db->prepare('
			SELECT id FROM :tablename 
			WHERE soignant = :id
			AND id_pathologie <> -1');
		
		$q->bindValue( ':tablename', $this->_db->prefix() . "patients") ;
		
		// Attribution des valeaurs
		$q->bindValue(	':id'	,	$e->id() ) ;
		// Execution
		$q->execute()  or die( print_r( $q->errorInfo() ) ) ;
		
		// Récupération
		$d = $q->fetch(PDO::FETCH_ASSOC) ;
		return count($d) ;
	}
	
	
	public function findPatient(eleve $e)
	{
		// Préparation
		$q = $this->_db->prepare('SELECT id FROM :tablename WHERE soignant = :id');
		
		$q->bindValue( ':tablename', $this->_db->prefix() . "patients") ;
		
		// Attribution des valeaurs
		$q->bindValue(	':id'	,	$e->id() ) ;
		// Execution
		$q->execute()  or die( print_r( $q->errorInfo() ) ) ;
		
		// Récupération
		$d = $q->fetch(PDO::FETCH_ASSOC) ;
		return ( $d != null ) ? $d['id'] : null ;
	}	
	
	public function get($id)
	{
		// Préparation
		$q = $this->_db->prepare("SELECT * FROM :tablename WHERE id = :id");
		
		$q->bindValue( ':tablename', $this->_db->prefix() . $this->_table) ;
		
		//Attribution des valeurs
		$q->bindValue(	':id'		,	$id		);
		// Execution
		$q->execute()  or die( print_r( $q->errorInfo() ) ) ;
		// Récupération
		$d = $q->fetch(PDO::FETCH_ASSOC) ;
		return new eleve( $d ) ;
		$q->closeCursor() ;
	}
	
	
	public function update($eleve)
	{
		// Préparation
		$q = $this->_db->prepare("UPDATE :tablename SET
			nom = :nom, prenom = :prenom, matricule = :matricule, annee = :annee, email = :email, telephone = :telephone, statut = :statut, soins = :soins
			WHERE id = :id" ) ;
		$q->bindValue( ':tablename', $this->_db->prefix() . $this->_table) ;
		
		// Attribution des valeurs
		$q->bindValue(	':id'		,	$eleve->id()			);
		$q->bindValue(	':nom'		,	$eleve->nom()			);
		$q->bindValue(	':prenom'	,	$eleve->prenom()		);
		$q->bindValue(	':matricule',	$eleve->matricule()		);
		$q->bindValue(	':annee'	,	$eleve->annee()			);
		$q->bindValue(	':email'	,	$eleve->email()			);
		$q->bindValue(	':telephone',	$eleve->telephone()		);
		$q->bindValue(	':statut'	,	$eleve->statut()		);
		$q->bindValue(	':soins'	,	$eleve->soins()			);
		
		// Execution
		$q->execute()  or die( print_r( $q->errorInfo() ) ) ;
	}
	
	public function madeHeal($eleve)
	{
		$q = $this->_db->prepare("UPDATE :tablename SET soins = IFNULL(soins, 0) + 1 WHERE id = :id" );
		$q->bindValue( ':tablename', $this->_db->prefix() . $this->_table) ;
		
		// Attribution des valeurs
		$q->bindValue(	':id'		,	$eleve->id()			);
		
		// Execution
		$q->execute()  or die( print_r( $q->errorInfo() ) ) ;
	}
	
	public function updatePassword(eleve $eleve)
	{
		// Préparation
		$q = $this->_db->prepare("UPDATE :tablename SET
			motDePasse = :password
			WHERE id = :id" ) ;
		$q->bindValue( ':tablename', $this->_db->prefix() . $this->_table) ;
		
		// Attribution des valeurs
		$q->bindValue(	':id'		,	$eleve->id()			);
		$q->bindValue(	':password'	,	$eleve->motDePasse()	);
		
		// Execution
		$q->execute()  or die( print_r( $req->errorInfo() ) ) ;
	}
	public function approve(eleve $eleve)
	{
		// Préparation
		$q = $this->_db->prepare("UPDATE :tablename SET statut = 'approuve' WHERE id = :id" ) ;
		$q->bindValue( ':tablename', $this->_db->prefix() . $this->_table) ;
		
		// Attribution des valeurs
		$q->bindValue(	':id'		,	$eleve->id()			);		
		// Execution
		$q->execute()  or die( print_r( $q->errorInfo() ) ) ;
	}
	public function ban(eleve $eleve)
	{
		// Préparation
		$q = $this->_db->prepare("UPDATE :tablename SET statut = 'banni' WHERE id = :id" ) ;
		$q->bindValue( ':tablename', $this->_db->prefix() . $this->_table) ;
		
		// Attribution des valeurs
		$q->bindValue(	':id'		,	$eleve->id()			);		
		// Execution
		$q->execute()  or die( print_r( $q->errorInfo() ) ) ;
	}
	public function chadmin(eleve $eleve)
	{
		// Préparation
		$q = $this->_db->prepare("UPDATE :tablename SET statut = 'administrateur' WHERE id = :id" ) ;
		$q->bindValue( ':tablename', $this->_db->prefix() . $this->_table) ;
		
		// Attribution des valeurs
		$q->bindValue(	':id'		,	$eleve->id()			);		
		// Execution
		$q->execute()  or die( print_r( $q->errorInfo() ) ) ;
	}
	
	public function getList($value=0, $statut='all')
	{
		// Préparation
		if ( $value == 0 and $statut == 'all' )
		{
			$q = $this->_db->prepare("SELECT * FROM :tablename WHERE statut != 'banni' ORDER BY nom");
		}
		else
		{
			if ($value != 0 and $statut == 'all')
			{
				$q = $this->_db->prepare("SELECT * FROM :tablename WHERE annee = :value AND statut != 'banni' ORDER BY nom");
				$q->bindValue(	':value'		,	$value		);
			}
			elseif ($value == 0 and $statut != 'all')
			{
				$q = $this->_db->prepare("SELECT * FROM :tablename WHERE statut = :statut ORDER BY nom");
				$q->bindValue(	':statut'		,	$statut		);
			}
			else
			{
				$q = $this->_db->prepare("SELECT * FROM :tablename WHERE annee = :value AND statut = :statut ORDER BY nom");
				$q->bindValue(	':value'		,	$value		);
				$q->bindValue(	':statut'		,	$statut		);
			}

		}
		
		$q->bindValue( ':tablename', $this->_db->prefix() . $this->_table) ;
		$q->execute()  or die( print_r( $req->errorInfo() ) ) ;	
		
		// Récupération
		$d = $q->fetchAll(PDO::FETCH_ASSOC) ;
		foreach ($d as $key => $value)
		{
			$d[$key] = new eleve( $value ) ;
		}
		return $d ;
	}
	
	public function matriculeExiste($matri)
	{
		// Préparation
		$q = $this->_db->prepare('SELECT id FROM :tablename WHERE matricule = :matricule');
		$q->bindValue( ':tablename', $this->_db->prefix() . $this->_table) ;
		
		// Attribution des valeaurs
		$q->bindValue(	':matricule'	,	$matri) ;
		// Execution
		$q->execute()  or die( print_r( $req->errorInfo() ) ) ;
		
		// Récupération
		$d = $q->fetch(PDO::FETCH_ASSOC) ;
		return ( $d ) ? true : false ;
	}
	
	public function getId($matri)
	{
		// Préparation
		$q = $this->_db->prepare('SELECT id FROM :tablename WHERE matricule = :matricule');
		$q->bindValue( ':tablename', $this->_db->prefix() . $this->_table) ;
		// Attribution des valeaurs
		$q->bindValue(	':matricule'	,	$matri) ;
		// Execution
		$q->execute()  or die( print_r( $req->errorInfo() ) ) ;
		
		// Récupération
		$d = $q->fetch(PDO::FETCH_ASSOC) ;
		return $d['id'] ;
	}
	public function idExiste($id)
	{
		// Préparation
		$q = $this->_db->prepare('SELECT id FROM :tablename WHERE id = :id');
		$q->bindValue( ':tablename', $this->_db->prefix() . $this->_table) ;
		
		// Attribution des valeaurs
		$q->bindValue(	':id'	,	$id) ;
		// Execution
		$q->execute()  or die( print_r( $q->errorInfo() ) ) ;
		
		// Récupération
		$d = $q->fetch(PDO::FETCH_ASSOC) ;
		return ( $d ) ? true : false ;
	}
	
	public function nombre(string $statut=null)
	{
		if ($statut == null)
		{
			$q = $this->_db->prepare('SELECT COUNT(id) AS n FROM :tablename WHERE statut != "banni"');
		}
		else
		{
			$q = $this->_db->prepare('SELECT COUNT(id) AS n FROM :tablenameeleves WHERE statut = :statut');
		}
		
		$q->bindValue( ':tablename', $this->_db->prefix() . $this->_table) ;
		
		// Attribution des valeaurs
		$q->bindValue(	':statut'	,	$statut) ;
		// Execution
		$q->execute()  or die( print_r( $q->errorInfo() ) ) ;
		
		// Récupération
		$d = $q->fetch(PDO::FETCH_ASSOC) ;
		return $d['n'];
		$q->closeCursor() ;
	}
	
}

