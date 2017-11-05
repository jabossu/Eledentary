<?php

class patientsManager
{
	//	internal variables
	private $_db ;
	
	//	Constructor
	function __construct ($db)
	{
		$this->_db = $db;
	}
	

	// Fonctions
	//====================
	
	public function genId()
	{
		do {
			$id = uniqid();	    
		} while ($this->existe($id));
		return $id;
	}
	
	function add(patient $p)
	{
		// Preparation
		$q = $this->_db->prepare("INSERT INTO eld_patients
		SET	id = :id,
			nom = :nom,
			prenom = :prenom,
			cnp = :cnp,
			dent = :dent,
			id_pathologie = :id_patho,
			details = :details,
			email = :email,
			addresse = :addresse,
			telephone = :telephone,
			soignant = 0") ;
		
		// Attribution des valeurs
		$q->bindValue(':id', $this->genId() );
		$q->bindValue(':nom', $p->nom());
		$q->bindValue(':prenom', $p->prenom());
		$q->bindValue(':cnp', $p->cnp());
		
		$q->bindValue(':dent', ( $p->dent() != null ) ? $p->dent() : '---' );
		$q->bindValue(':id_patho', ( $p->id_patho() != null ) ? $p->id_patho() : '---' );
		$q->bindValue(':details', ( $p->details() != null ) ? $p->details() : '---' );
		$q->bindValue(':email', ( $p->email() != null ) ? $p->email() : '---' );
		$q->bindValue(':addresse', ( $p->addresse() != null ) ? $p->addresse() : '---' );
		$q->bindValue(':telephone', ( $p->telephone() != null ) ? $p->telephone() : '---' );
		
		// Execution
		$q->execute() or die( print_r( $q->errorInfo() ) ) ;
		
		// Récupération
		return true ;
		$q->closeCursor() ;
	}
	
	function delete(patient $p)
	{
		// Preparation
		$q = $this->_db->prepare("DELETE FROM eld_patients	WHERE	id = :id") ;
		
		// Attribution des valeurs
		$q->bindValue(':id', $p->id() );
		
		// Execution
		$q->execute() or die( print_r( $q->errorInfo() ) ) ;
		
		// Récupération
		$q->closeCursor() ;
	}
	
	function update(patient $p)
	{
		// Preparation
		$q = $this->_db->prepare("UPDATE eld_patients
		SET	nom = :nom,
			prenom = :prenom,
			cnp = :cnp,
			dent = :dent,
			id_pathologie = :id_patho,
			details = :details,
			email = :email,
			addresse = :addresse,
			telephone = :telephone,
			soignant = :soignant
		WHERE id = :id") ;
		
		// Attribution des valeurs
		$q->bindValue(':id', $p->id());
		$q->bindValue(':nom', $p->nom());
		$q->bindValue(':prenom', $p->prenom());
		$q->bindValue(':cnp', $p->cnp());
		$q->bindValue(':dent', $p->p_dent());
		$q->bindValue(':id_patho', $p->id_patho());
		
		$q->bindValue(':details', ( $p->details() != null ) ? $p->details() : '---' );
		$q->bindValue(':email', ( $p->email() != null ) ? $p->email() : '---' );
		$q->bindValue(':addresse', ( $p->addresse() != null ) ? $p->addresse() : '---' );
		$q->bindValue(':telephone', ( $p->telephone() != null ) ? $p->telephone() : '---' );
		$q->bindValue(':soignant', ( $p->soignant() != null ) ? $p->soignant() : 0 );
		
		// Execution
		$q->execute() or die( print_r( $q->errorInfo() ) ) ;
		
		// Récupération
		return true ;
		$q->closeCursor() ;
	}
	
	function remove($id)
	{
		// Preparation
		$q = $this->_db->prepare("DELETE FROM eld_patients	WHERE	id = :id") ;
		
		// Attribution des valeurs
		$q->bindValue(':id', $id);
		
		// Execution
		$q->execute() or die( print_r( $q->errorInfo() ) ) ;
		
		// Récupération
		$q->closeCursor() ;
	}
	
	function liste( $patho=null, $showReserved=false)
	{
		$patho = ( intval($patho) == 0 )		? '%'	: $patho	;
		// Preparation
		$q = $this->_db->prepare("
			SELECT
					p.id 		AS id,
					p.nom		AS nom,
					p.prenom	AS prenom,
					p.cnp		AS cnp,
					p.id_pathologie	AS id_patho,
					p.email		AS email,
					p.addresse	AS addresse,
					p.telephone	AS telephone,
					p.details	AS details,
					p.dent		AS dent,
					p.soignant	AS soignant,
					q.annees	AS annees,
					q.nom_fr_FR	AS patho_fr_FR,
					q.nom_en_EN	AS patho_en_EN
			FROM eld_patients AS p
			LEFT JOIN eld_pathologies AS q
			ON p.id_pathologie = q.id
			WHERE	q.id LIKE :pathofilter
				AND p.id_pathologie <> -1
			") ;
		
		$q->bindValue(':pathofilter' , $patho ) ;
		
		// Récupération
		$q->execute() or die(print_r($q->errorInfo())) ;
		$d = $q->fetchAll(PDO::FETCH_ASSOC) ;
		$r = array();
		foreach ($d as $k => $v)
		{
			if ( $GLOBALS['_SESSION']['langue'] == 'fr_FR' )
			{
				$v['patho'] = $d[$k]['patho_fr_FR'] ;
			}
			else
			{
				$v['patho'] = $d[$k]['patho_en_EN'] ;
			}
			if ( $v['soignant'] == "0" or $showReserved == true )
			{
				$r[] = new patient($v) ;
			}
		}
		return $r ;
		$q->closeCursor() ;
	}
	
	function listeReserved( $e_id )
	{
		// Preparation
		$q = $this->_db->prepare("
			SELECT
					p.id 		AS id,
					p.nom		AS nom,
					p.prenom	AS prenom,
					p.cnp		AS cnp,
					p.id_pathologie	AS id_patho,
					p.email		AS email,
					p.addresse	AS addresse,
					p.telephone	AS telephone,
					p.details	AS details,
					p.dent		AS dent,
					p.soignant	AS soignant,
					q.annees	AS annees,
					q.nom_fr_FR	AS patho_fr_FR,
					q.nom_en_EN	AS patho_en_EN
			FROM eld_patients AS p
			LEFT JOIN eld_pathologies AS q
			ON p.id_pathologie = q.id
			WHERE p.soignant = :e_id
				AND p.id_pathologie <> -1
			ORDER BY p.id DESC") ;
		
		$q->bindValue(':e_id' , $e_id ) ;
		
		// Récupération
		$q->execute() or die(print_r($q->errorInfo())) ;
		$d = $q->fetchAll(PDO::FETCH_ASSOC) ;
		$r = array();
		foreach ($d as $k => $v)
		{
			if ( $GLOBALS['_SESSION']['langue'] == 'fr_FR' )
			{
				$v['patho'] = $d[$k]['patho_fr_FR'] ;
			}
			else
			{
				$v['patho'] = $d[$k]['patho_en_EN'] ;
			}
			$r[] = new patient($v) ;
		}
		return $r ;
		$q->closeCursor() ;
	}
	

	public function existe($id)
	{
		// Préparation
		$q = $this->_db->prepare('SELECT id FROM eld_patients WHERE id = :id');
		// Attribution des valeaurs
		$q->bindValue(	':id'	,	$id) ;
		// Execution
		$q->execute()  or die( print_r( $q->errorInfo() ) ) ;
		
		// Récupération
		$d = $q->fetch(PDO::FETCH_ASSOC) ;
		return ( $d ) ? true : false ;
		$q->closeCursor() ;
	}
	
	public function isFree(patient $p)
	{
		// Préparation
		$q = $this->_db->prepare('SELECT soignant FROM eld_patients WHERE id = :id');
		// Attribution des valeaurs
		$q->bindValue(	':id'	,	$p->id() ) ;
		// Execution
		$q->execute()  or die( print_r( $q->errorInfo() ) ) ;
		
		// Récupération
		$d = $q->fetch(PDO::FETCH_ASSOC) ; 
		return ( $d['soignant'] == 0 ) ? true : false ;
		$q->closeCursor() ;
	}
	
	public function reserve(patient $p, eleve $e)
	{
		// Préparation
		$q = $this->_db->prepare('UPDATE eld_patients SET	soignant = :soignant WHERE id = :id');
		// Attribution des valeaurs
		$q->bindValue(	':id'		,	$p->id() ) ;
		$q->bindValue(	':soignant'	,	$e->id() ) ;
		// Execution
		$q->execute()  or die( print_r( $q->errorInfo() ) ) ;
		$q->closeCursor() ;
	}
	public function free(patient $p)
	{
		// Préparation
		$q = $this->_db->prepare('UPDATE eld_patients SET	soignant = 0 WHERE id = :id');
		// Attribution des valeaurs
		$q->bindValue(	':id'		,	$p->id() ) ;
		// Execution
		$q->execute()  or die( print_r( $q->errorInfo() ) ) ;
		$q->closeCursor() ;
	}
	
	public function heal(patient $p)
	{
		// Préparation
		$q = $this->_db->prepare('UPDATE eld_patients SET	id_pathologie = -1 WHERE id = :id');
		// Attribution des valeaurs
		$q->bindValue(	':id'		,	$p->id() ) ;
		// Execution
		$q->execute()  or die( print_r( $q->errorInfo() ) ) ;
		$q->closeCursor() ;
	}
	
	public function get($id)
	{
		// Préparation
		$q = $this->_db->prepare("
			SELECT
					p.id 		AS id,
					p.nom		AS nom,
					p.prenom	AS prenom,
					p.cnp		AS cnp,
					p.id_pathologie	AS id_patho,
					p.email		AS email,
					p.addresse	AS addresse,
					p.telephone	AS telephone,
					p.details	AS details,
					p.dent		AS dent,
					p.soignant	AS soignant,
					q.annees	AS annees,
					q.nom_fr_FR	AS patho_fr_FR,
					q.nom_en_EN	AS patho_en_EN
			FROM eld_patients AS p
			LEFT JOIN eld_pathologies AS q
				ON p.id_pathologie = q.id
			WHERE p.id LIKE :id
			ORDER BY nom DESC");
		//Attribution des valeurs
		$q->bindValue(	':id'	, $id	);
		// Execution
		$q->execute()  or die( print_r( $q->errorInfo() ) ) ;
		// Récupération
		$d = $q->fetch(PDO::FETCH_ASSOC) ;
		if ( $GLOBALS['_SESSION']['langue'] == 'fr_FR' )
			{
				$d['patho'] = $d['patho_fr_FR'] ;
			}
			else
			{
				$d['patho'] = $d['patho_en_EN'] ;
			}
		return new patient( $d ) ;
		$q->closeCursor() ;
	}
	
	function getSoignant($id)
	{
		/*if ( $this->existe($id) == false )
		{ exit 1 }*/
		
		// Preparation
		$q = $this->_db->prepare("SELECT soignant FROM eld_patients	WHERE	id = :id") ;
		// Attribution des valeurs
		$q->bindValue(':id', $id);
		
		// Execution
		$q->execute() or die( print_r( $q->errorInfo() ) ) ;
		
		// Récupération
		$d = $q->fetch(PDO::FETCH_ASSOC) ;
		return $d['soignant'] ;
		$q->closeCursor() ;
	}
	
	public function compter( $patho=null, $onlyfree=false )
	{
		$patho = ( intval($patho) == 0 ) ? '%'	: $patho ;
		$soignant = ( $onlyfree == true ) ? '0'	: '%' ;
		
		// Préparation
		$q = $this->_db->prepare('SELECT
			COUNT(id) AS n
			FROM eld_patients
			WHERE id_pathologie LIKE :patho AND soignant LIKE :soignant');
		// Attribution des valeaurs
		$q->bindValue(	':patho'	,	$patho) ;
		$q->bindValue(	':soignant'	,	$soignant) ;
		// Execution
		$q->execute()  or die( print_r( $q->errorInfo() ) ) ;
		
		// Récupération
		$d = $q->fetch(PDO::FETCH_ASSOC) ;
		return $d['n'];
		$q->closeCursor() ;
	}

}

