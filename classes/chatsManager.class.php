<?php

class chatsManager
{
	//	internal variables
	private $_db ;
	private $_table ;
	
	//	Constructor
	function __construct ($db)
	{
		$this->_db = $db;
		$this->_table = "dentchat" ;
	}
	

	// Fonctions
	//====================
	
	function add(chat $chat)
	{
		// Preparation
		$q = $this->_db->prepare("
			INSERT INTO :tablename
			SET id = '', timestamp = CONVERT_TZ( NOW() ,'+00:00','+01:00') , userid = :userid, message = :message") ;
		$q->bindValue( ':tablename', $this->_db->prefix() . $this->_table) ;
		
		// Attribution des valeurs
		$q->bindValue(':userid', $chat->userid());
		$q->bindValue(':message', $chat->message());
		
		// Execution
		$q->execute() or die( print_r( $q->errorInfo() ) ) ;
		
		// Récupération
		$q->closeCursor() ;
	}
	function get()
	{
		// Preparation
		$q = $this->_db->prepare("
			SELECT
				d.userid AS userid,
				DATE_FORMAT(d.timestamp, '%H:%i') AS time,
				DATE(d.timestamp) AS day,
				CONCAT( LEFT(e.prenom, 1),  '.', SUBSTR(e.nom, 1, 7) ) AS username,
				d.message AS message,
				e.annee AS anneeuser
			FROM :tablename AS d
			LEFT JOIN :tablename2 AS e
			ON e.id = d.userid
			ORDER BY d.timestamp DESC
			LIMIT 0, 20") or print_r($this->_db->errorInfo());
		
		$q->bindValue( ':tablename', $this->_db->prefix() . $this->_table) ;
		$q->bindValue( ':tablename2', $this->_db->prefix() . "eleves") ;
		
		// Execution
		$q->execute() or die( print_r( $q->errorInfo() ) ) ;
		
		// Récupération
		//$d = array_reverse( $q->fetchAll(PDO::FETCH_ASSOC) ) ;
		$d = $q->fetchAll(PDO::FETCH_ASSOC) ;
		foreach ($d as $k => $v)
		{	$d[$k] = new chat($v) ; }
		return $d ;
		$q->closeCursor() ;
	}
	
}

