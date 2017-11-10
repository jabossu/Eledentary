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
			INSERT INTO :tablename
			SET id = '', id_patient = :patientid , texte = :texte, id_patho = :id_patho") ;
		
		$q->bindvalues(':tablename', $this->_db->prefix() . "anamnese");
		
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
		$q = $this->_db->prepare("
			SELECT		id_patient, texte, id_patho
			FROM :tablename
			WHERE id = :id") or print_r($this->_db->errorInfo());
		
		$q->bindvalues(':tablename', $this->_db->prefix() . "anamnese");
		
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
		$q = $this->_db->prepare("DELETE FROM :tablename	WHERE	id = :id") ;
		
		$q->bindvalues(':tablename', $this->_db->prefix() . "anamnese");
		
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
		$q = $this->_db->prepare('SELECT id FROM :tablename WHERE id = :id');
		$q->bindvalues(':tablename', $this->_db->prefix() . "anamnese");
		// Attribution des valeurs
		$q->bindValue(	':id'	,	$id) ;
		// Execution
		$q->execute()  or die( print_r( $q->errorInfo() ) ) ;
		
		// Récupération
		$d = $q->fetch(PDO::FETCH_ASSOC) ;
		return ( $d ) ? true : false ;
	}
	
}

