<?php

class passkeysManager
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
	
	function add(passkey $k)
	{
		// Preparation
		$q = $this->_db->prepare("INSERT INTO eld_reset_keys SET
			id = '', value = :value, date = NOW(), userid = :userid") ;
		
		// Attribution des valeurs
		$q->bindValue(':userid', $k->userid());
		$q->bindValue(':value', $k->value());
		
		// Execution
		$q->execute() or die( print_r( $q->errorInfo() ) ) ;
		
		// Récupération
		$q->closeCursor() ;
	}
	
	function get($id)
	{
		$id = intval( $id ) ;
		
		// Preparation
		$q = $this->_db->prepare("SELECT * FROM eld_reset_keys WHERE id = :id") ;
		
		// Attribution des valeurs
		$q->bindValue(':id', $id);
		// Execution
		$q->execute() or die( print_r( $q->errorInfo() ) ) ;
		
		// Récupération
		$d = new passkey( $q->fetch(PDO::FETCH_ASSOC) ) ;
		return $d;
		$q->closeCursor() ;
	}
	
	function get_with_id($id)
	{		
		// Preparation
		$q = $this->_db->prepare("SELECT * FROM eld_reset_keys WHERE userid = :id") ;
		
		// Attribution des valeurs
		$q->bindValue(':id', $id);
		// Execution
		$q->execute() or die( print_r( $q->errorInfo() ) ) ;
		
		// Récupération
		$d = new passkey( $q->fetch(PDO::FETCH_ASSOC) ) ;
		return $d;
		$q->closeCursor() ;
	}
	
	function get_with_value($value)
	{		
		// Preparation
		$q = $this->_db->prepare("SELECT * FROM eld_reset_keys WHERE value = :value") ;
		
		// Attribution des valeurs
		$q->bindValue(':value', $value);
		// Execution
		$q->execute() or die( print_r( $q->errorInfo() ) ) ;
		
		// Récupération
		$d = new passkey( $q->fetch(PDO::FETCH_ASSOC) ) ;
		return $d;
		$q->closeCursor() ;
	}
	
	function delete(passkey $k)
	{		
		// Preparation
		$q = $this->_db->prepare("DELETE FROM eld_reset_keys WHERE id = :id") ;
		
		// Attribution des valeurs
		$q->bindValue(':id', $k->id() );
		// Execution
		$q->execute() or die( print_r( $q->errorInfo() ) ) ;
		
		// Récupération
		$q->closeCursor() ;
	}
	
	function existe($id)
	{	
		$id = intval( $id ) ;
		// Preparation
		$q = $this->_db->prepare("SELECT id FROM eld_reset_keys WHERE id = :id") ;
		
		// Attribution des valeurs
		$q->bindValue(':id', $id );
		// Execution
		$q->execute() or die( print_r( $q->errorInfo() ) ) ;
		
		// Récupération
		$d = $q->fetch() ;
		return ( $d ) ? true : false ;
		$q->closeCursor() ;
	}
	
	function clefExiste($str)
	{	
		// Preparation
		$q = $this->_db->prepare("SELECT id FROM eld_reset_keys WHERE value = :value") ;
		
		// Attribution des valeurs
		$q->bindValue(':value', $str );
		// Execution
		$q->execute() or die( print_r( $q->errorInfo() ) ) ;
		
		// Récupération
		$d = $q->fetch() ;
		return ( $d ) ? true : false ;
		$q->closeCursor() ;
	}
	
	function demandeExiste($id)
	{	
		$id = intval( $id ) ;
		// Preparation
		$q = $this->_db->prepare("SELECT id FROM eld_reset_keys WHERE userid = :id") ;
		
		// Attribution des valeurs
		$q->bindValue(':id', $id );
		// Execution
		$q->execute() or die( print_r( $q->errorInfo() ) ) ;
		
		// Récupération
		$d = $q->fetch() ;
		return ( $d ) ? true : false ;
		$q->closeCursor() ;
	}
}

