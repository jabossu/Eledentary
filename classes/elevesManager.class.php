<?php

class elevesManager
{
	
	//	internal variables
	private $_db ;
	
	//	Constructor
	public function __construct ($db)
	{
		$this->_db = $db;
	}
	
	// ===================================
	//			Fonctions
	// ===================================
	
	public function genId()
	{
		do {
			$id = uniqid();	    
		} while ($this->idExiste($id));
		return $id;
	}
	
	public function add(eleve $eleve)
	{
		// Preparation
		$q = $this->_db->prepare("INSERT INTO eld_eleves SET
			id = :id, nom = :nom, prenom = :prenom, matricule = :matricule, motDepasse = :motDepasse, annee = :annee, email = :email, telephone = :telephone, statut = :statut, soins = :soins") ;
		
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
		$q = $this->_db->prepare("DELETE FROM eld_eleves	WHERE	id = :id") ;
		
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
		$q = $this->_db->prepare('SELECT id FROM eld_patients WHERE soignant = :id');
		// Attribution des valeaurs
		$q->bindValue(	':id'	,	$e->id() ) ;
		// Execution
		$q->execute()  or die( print_r( $q->errorInfo() ) ) ;
		
		// Récupération
		$d = $q->fetch(PDO::FETCH_ASSOC) ;
		return ( $d == null ) ? false : true ;
	}
	
	public function hasReserved(eleve $e)
	{
		// Préparation
		$q = $this->_db->prepare('
			SELECT id FROM eld_patients 
			WHERE soignant = :id
			AND id_pathologie <> -1');
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
		$q = $this->_db->prepare('SELECT id FROM eld_patients WHERE soignant = :id');
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
		$q = $this->_db->prepare("SELECT * FROM eld_eleves WHERE id = :id");
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
		$q = $this->_db->prepare("UPDATE eld_eleves SET
			nom = :nom, prenom = :prenom, matricule = :matricule, annee = :annee, email = :email, telephone = :telephone, statut = :statut, soins = :soins
			WHERE id = :id" ) ;
		
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
		$q->execute()  or die( print_r( $req->errorInfo() ) ) ;
	}
	public function updatePassword($eleve)
	{
		// Préparation
		$q = $this->_db->prepare("UPDATE eld_eleves SET
			motDePasse = :password
			WHERE id = :id" ) ;
		
		// Attribution des valeurs
		$q->bindValue(	':id'		,	$eleve->id()			);
		$q->bindValue(	':password'	,	$eleve->motDePasse()	);
		
		// Execution
		$q->execute()  or die( print_r( $req->errorInfo() ) ) ;
	}
	public function approve($eleve)
	{
		// Préparation
		$q = $this->_db->prepare("UPDATE eld_eleves SET statut = 'approuve' WHERE id = :id" ) ;
		// Attribution des valeurs
		$q->bindValue(	':id'		,	$eleve->id()			);		
		// Execution
		$q->execute()  or die( print_r( $q->errorInfo() ) ) ;
	}
	public function ban($eleve)
	{
		// Préparation
		$q = $this->_db->prepare("UPDATE eld_eleves SET statut = 'banni' WHERE id = :id" ) ;
		// Attribution des valeurs
		$q->bindValue(	':id'		,	$eleve->id()			);		
		// Execution
		$q->execute()  or die( print_r( $q->errorInfo() ) ) ;
	}
	public function chadmin($eleve)
	{
		// Préparation
		$q = $this->_db->prepare("UPDATE eld_eleves SET statut = 'administrateur' WHERE id = :id" ) ;
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
			$q = $this->_db->query("SELECT * FROM eld_eleves WHERE statut != 'banni' ORDER BY nom");
		}
		else
		{
			if ($value != 0 and $statut == 'all')
			{
				$q = $this->_db->prepare("SELECT * FROM eld_eleves WHERE annee = :value AND statut != 'banni' ORDER BY nom");
				$q->bindValue(	':value'		,	$value		);
			}
			elseif ($value == 0 and $statut != 'all')
			{
				$q = $this->_db->prepare("SELECT * FROM eld_eleves WHERE statut = :statut ORDER BY nom");
				$q->bindValue(	':statut'		,	$statut		);
			}
			else
			{
				$q = $this->_db->prepare("SELECT * FROM eld_eleves WHERE annee = :value AND statut = :statut ORDER BY nom");
				$q->bindValue(	':value'		,	$value		);
				$q->bindValue(	':statut'		,	$statut		);
			}
			$q->execute()  or die( print_r( $req->errorInfo() ) ) ;
		}
			
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
		$q = $this->_db->prepare('SELECT id FROM eld_eleves WHERE matricule = :matricule');
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
		$q = $this->_db->prepare('SELECT id FROM eld_eleves WHERE matricule = :matricule');
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
		$q = $this->_db->prepare('SELECT id FROM eld_eleves WHERE id = :id');
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
			$q = $this->_db->query('SELECT COUNT(id) AS n FROM eld_eleves WHERE statut != "banni"');
		}
		else
		{
			// Préparation
			$q = $this->_db->prepare('SELECT COUNT(id) AS n FROM eld_eleves WHERE statut = :statut');
			// Attribution des valeaurs
			$q->bindValue(	':statut'	,	$statut) ;
			// Execution
			$q->execute()  or die( print_r( $q->errorInfo() ) ) ;
		}
		
		// Récupération
		$d = $q->fetch(PDO::FETCH_ASSOC) ;
		return $d['n'];
		$q->closeCursor() ;
	}
	
}

