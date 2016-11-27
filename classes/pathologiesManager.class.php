<?php

class pathologiesManager
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
	
	function add(pathologie $patho)
	{
		// Preparation
		$q = $this->_db->prepare("INSERT INTO eld_pathologies
			SET		nom_fr_FR = :nom_fr_FR, nom_en_EN = :nom_en_EN, annees = :annees, details_fr_FR = :details_fr_FR, details_en_EN = :details_en_EN") ;
		
		// Attribution des valeurs
		$q->bindValue(':nom_fr_FR', $patho->nom('fr_FR'));
		$q->bindValue(':nom_en_EN', $patho->nom('en_EN'));
		$q->bindValue(':annees', $patho->p_annees());
		$q->bindValue(':details_fr_FR', $patho->details('fr_FR'));
		$q->bindValue(':details_en_EN', $patho->details('en_EN'));
		
		// Execution
		$q->execute() or die( print_r( $q->errorInfo() ) ) ;
		
		// Récupération
		return true ;
		$q->closeCursor() ;
	}
	
	function update(pathologie $patho)
	{
		// Preparation
		$q = $this->_db->prepare("UPDATE eld_pathologies
			SET		nom_fr_FR = :nom_fr_FR, nom_en_EN = :nom_en_EN, annees = :annees, details_fr_FR = :details_fr_FR, details_en_EN = :details_fr_FR
			WHERE	id = :id") ;
		
		// Attribution des valeurs
		$q->bindValue(':nom_fr_FR', $patho->nom('fr_FR'));
		$q->bindValue(':nom_en_EN', $patho->nom('en_EN'));
		$q->bindValue(':annees', $patho->p_annees());
		$q->bindValue(':details_fr_FR', $patho->details('fr_FR'));
		$q->bindValue(':details_en_EN', $patho->details('en_EN'));
		$q->bindValue(':id', $patho->id());
		
		// Execution
		$q->execute() or die( print_r( $q->errorInfo() ) ) ;
		
		// Récupération
		return true ;
		$q->closeCursor() ;
	}
	
	function remove($id)
	{
		// Preparation
		$q = $this->_db->prepare("DELETE FROM eld_pathologies	WHERE	id = :id") ;
		
		// Attribution des valeurs
		$q->bindValue(':id', $id);
		
		// Execution
		$q->execute() or die( print_r( $q->errorInfo() ) ) ;
		
		// Récupération
		$q->closeCursor() ;
	}
		
	function existe($id)
	{
		// Preparation
		$q = $this->_db->prepare("SELECT * FROM eld_pathologies	WHERE	id = :id") ;
		
		// Attribution des valeurs
		$q->bindValue(':id', $id);
		
		// Execution
		$q->execute() or die( print_r( $q->errorInfo() ) ) ;
		$d = $q->fetch(PDO::FETCH_ASSOC) ;
		
		// Récupération
		if ($d == True)
		{
			return true ;
		}
		else
		{
			return false ;
		}
		$q->closeCursor() ;
	}
	
	function get($id)
	{
		// Preparation
		$q = $this->_db->prepare("SELECT * FROM eld_pathologies	WHERE	id = :id") ;
		
		// Attribution des valeurs
		$q->bindValue(':id', $id);
		
		// Execution
		$q->execute() or die( print_r( $q->errorInfo() ) ) ;
		
		// Récupération
		$d = $q->fetch(PDO::FETCH_ASSOC) ;
		$d = new pathologie($d) ;
		return $d ;
		$q->closeCursor() ;
	}

	
	function liste()
	{
		// Preparation
		$q = $this->_db->query("
			SELECT *
			FROM eld_pathologies
			ORDER BY nom_fr_FR ASC")  or die( print_r( $q->errorInfo() ) ) ;
				
		// Récupération
		$d = $q->fetchAll(PDO::FETCH_ASSOC) ;
		foreach ($d as $k => $v)
		{
			$d[$k] = new pathologie($v) ;
		}
		return $d ;
		$q->closeCursor() ;
	}
}

