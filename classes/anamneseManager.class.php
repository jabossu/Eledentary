<?php

class anamnesesManager
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
	
	function add(anamnese $a)
	{
		// Preparation
		$q = $this->_db->prepare("
			INSERT INTO eld_anamnese
			SET id = '', id_patient = :patientid , texte = :texte, id_patho = :id_patho") ;
		
		// Attribution des valeurs
		$q->bindValue(':patientid', $a->id_patient());
		$q->bindValue(':texte', $a->texte());
		$q->bindValue(':id_patho', $a->id_patho());
		
		// Execution
		$q->execute() or die( print_r( $q->errorInfo() ) ) ;
		
		// Récupération
		$q->closeCursor() ;
	}
	function get()
	{
		// Preparation
		$q = $this->_db->query("
			SELECT		id_patient, texte, id_patho
			FROM eld_anamneses
			WHERE id = :id") or print_r($this->_db->errorInfo());
		
		// Récupération
		//$d = array_reverse( $q->fetchAll(PDO::FETCH_ASSOC) ) ;
		$d = $q->fetch(PDO::FETCH_ASSOC) ;
		$d[$k] = new anamnese($v) ; 
		return $d ;
		$q->closeCursor() ;
	}

	function remove($id)
	{
		// Preparation
		$q = $this->_db->prepare("DELETE FROM eld_anamneses	WHERE	id = :id") ;
		
		// Attribution des valeurs
		$q->bindValue(':id', $id);
		
		// Execution
		$q->execute() or die( print_r( $q->errorInfo() ) ) ;
		
		// Récupération
		$q->closeCursor() ;
	}

	public function existe($id)
	{
		// Préparation
		$q = $this->_db->prepare('SELECT id FROM eld_anamneses WHERE id = :id');
		// Attribution des valeurs
		$q->bindValue(	':id'	,	$id) ;
		// Execution
		$q->execute()  or die( print_r( $q->errorInfo() ) ) ;
		
		// Récupération
		$d = $q->fetch(PDO::FETCH_ASSOC) ;
		return ( $d ) ? true : false ;
	}
	
}

