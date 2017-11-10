<?php

class messagesManager
{
	//	internal variables
	private $_db ;
	private $_table ;
		
	//	Constructor
	function __construct ($db)
	{
		$this->_db = $db;
		$this->_table = "messages" ;
	}
	

	// Fonctions
	//====================
	
	function get($id)
	{
		$id = (int) $id ;
		
		// Preparation
		$q = $this->_db->prepare(
		"SELECT
			m.id AS id,
			m.timestamp AS timestamp,
			DATE_FORMAT(m.timestamp, '%a, %D %b \'%y, %H:%i') AS date,
			DATE_FORMAT(m.timestamp, '%d-%m-%Y') AS jour,
			m.objet AS objet,
			m.corps AS corps,
			m.etat AS etat,
			e.nom AS nom,
			e.prenom AS prenom,
			e.email AS email,
			e.id AS expediteur
		FROM :tablename AS m
		LEFT JOIN :tablename2 AS e
		ON m.expediteur=e.id
		WHERE m.id = :id");
		
		$q->bindValue( ':tablename', $this->_db->prefix() . $this->_table) ;
		$q->bindValue( ':tablename2', $this->_db->prefix() . "eleves") ;
		
		// Attribution des valeurs
		$q->bindValue(':id', $id);
		
		// Execution
		$q->execute() or die( print_r( $q->errorInfo() ) ) ;
		
		//Récupération
		$d = $q->fetch(PDO::FETCH_ASSOC) ;
		return new message($d);
		$q->closeCursor() ;	
	}
	
	function getListe()
	{
		$d = array() ;
		
		// Preparation
		$q = $this->_db->prepare("SELECT
			m.id AS id,
			m.timestamp AS timestamp,
			DATE_FORMAT(m.timestamp, '%a, %D %b \'%y, %H:%i') AS date,
			DATE_FORMAT(m.timestamp, '%d-%m-%Y') AS jour,
			m.objet AS objet,
			e.nom AS nom,
			e.prenom AS prenom,
			e.id AS idEleve
		FROM :tablename AS m
		LEFT JOIN :tablename2 AS e
		ON m.expediteur=e.id
		WHERE etat = 'lu'
		ORDER BY timestamp DESC") or die( print_r( $q->errorInfo() ) ) ;

		$q->bindValue( ':tablename', $this->_db->prefix() . $this->_table) ;
		$q->bindValue( ':tablename2', $this->_db->prefix() . "eleves") ;
		
		// Execution
		$q->execute() or die( print_r( $q->errorInfo() ) ) ;
		
		// Récupération
		$d['lus'] = $q->fetchAll(PDO::FETCH_ASSOC) ;
		
		foreach ($d['lus'] as $k => $v)
		{
			$d['lus'][$k] = new message($v) ;
		}
		
		$q = $this->_db->prepare("SELECT
			m.id AS id,
			m.timestamp AS timestamp,
			DATE_FORMAT(m.timestamp, '%a, %D %b \'%y, %H:%i') AS date,
			DATE_FORMAT(m.timestamp, '%d-%m-%Y') AS jour,
			m.objet AS objet,
			e.nom AS nom,
			e.prenom AS prenom,
			e.id AS idEleve
		FROM :tablename AS m
		LEFT JOIN :tablename2 AS e
		ON m.expediteur=e.id
		WHERE etat = 'nonlu'
		ORDER BY timestamp") or die( print_r( $q->errorInfo() ) ) ;
		
		$q->bindValue( ':tablename', $this->_db->prefix() . $this->_table) ;
		$q->bindValue( ':tablename2', $this->_db->prefix() . "eleves") ;
		
		// Execution
		$q->execute() or die( print_r( $q->errorInfo() ) ) ;
		
		// Récupération
		$d['nonlus'] = $q->fetchAll(PDO::FETCH_ASSOC) ;
		
		foreach ($d['nonlus'] as $k => $v)
		{
			$d['nonlus'][$k] = new message($v) ;
		}
		
		return $d ;		
		$q->closeCursor() ;	
	}
	
	function existeId( $id )
	{
		$id = (int) $id ;
		
		// Preparation
		$q = $this->_db->prepare("SELECT id FROM :tablename WHERE id = :id") ;
		$q->bindValue( ':tablename', $this->_db->prefix() . $this->_table) ;
		// Attribution des valeurs
		$q->bindValue(':id', $id);
		// Execution
		$q->execute() or die( print_r( $q->errorInfo() ) ) ;
		
		$d = $q->fetch() ;
		return ( $d ) ? true : false ;
		$q->closeCursor() ;
	}
	
	function writeMessage(message $message)
	{
		// Preparation
		$q = $this->_db->prepare("INSERT INTO :tablename SET
				objet = :objet, corps = :corps, expediteur = :expediteur, timestamp = NOW(), etat = 'nonlu'") ;
		$q->bindValue( ':tablename', $this->_db->prefix() . $this->_table) ;
		// Attribution des valeurs
		$q->bindValue(':objet', $message->objet());
		$q->bindValue(':corps', $message->corps());
		$q->bindValue(':expediteur', $message->expediteur());
		
		// Execution
		$q->execute() or die( print_r( $q->errorInfo() ) ) ;
		$q->closeCursor() ;
	}
	
	function markRead(message $message)
	{
		// Preparation
		$q = $this->_db->prepare("UPDATE :tablename SET etat = 'lu' WHERE id = :id") ;
		$q->bindValue( ':tablename', $this->_db->prefix() . $this->_table) ;
		$q->bindValue(':id', $message->id() ) ;
		$q->execute() or die( print_r( $q->errorInfo() ) ) ;
		$q->closeCursor() ;
	}
	function markUnread(message $message)
	{
		// Preparation
		$q = $this->_db->prepare("UPDATE :tablename SET etat = 'nonlu' WHERE id = :id") ;
		$q->bindValue( ':tablename', $this->_db->prefix() . $this->_table) ;
		$q->bindValue(':id', $message->id() ) ;
		$q->execute() or die( print_r( $q->errorInfo() ) ) ;
		$q->closeCursor() ;
	}
	
	function nombre($etat='tous')
	{
		switch ($etat)
		{
			case 'lu':
				$q = $this->_db->prepare("SELECT COUNT(id) AS n FROM :tablename WHERE etat = 'lu' ") or die( print_r( $q->errorInfo() ) ) ;
			break;
			
			case 'nonlu':
				$q = $this->_db->prepare("SELECT COUNT(id) AS n FROM :tablename WHERE etat = 'nonlu' ") or die( print_r( $q->errorInfo() ) ) ;
			break;
			
			default:
				$q = $this->_db->prepare("SELECT COUNT(id) AS n FROM :tablename") or die( print_r( $q->errorInfo() ) ) ;
			break;
		}
		$q->bindValue( ':tablename', $this->_db->prefix() . $this->_table) ;
		$q->execute() or die( print_r( $q->errorInfo() ) ) ;
		
		// Preparation
		$d = $q->fetch() ;
		return $d['n'] ;
		$q->closeCursor() ;
	}
	
}

