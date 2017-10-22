<?php

class logManager
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
	
	function add(logentry $l)
	{
		// Preparation
		$q = $this->_db->prepare("INSERT INTO eld_logs SET
			id = '', ipaddress = :ip, timestamp = NOW(), action = :action, iduser = :iduser, details = :details");
		
		// Attribution des valeurs
		$q->bindValue(':ip', $_SERVER['REMOTE_ADDR']) ;
		$q->bindValue(':action', $l->action() );
		$q->bindValue(':details', $l->details() );
		$q->bindValue(':iduser', $l->iduser() );
		
		// Execution
		$q->execute() or die( print_r( $q->errorInfo() ) ) ;
		
		// Récupération
		$q->closeCursor() ;
	}
	
	function getAll()
	{
		// Preparation
		$q = $this->_db->query("SELECT
			l.timestamp AS timestamp,
			l.ipaddress AS ipaddress,
			DATE_FORMAT(l.timestamp, '[ %a %d-%b-%y ] %H:%i') AS date,
			l.action AS action,
			l.iduser AS iduser,
			l.details AS details,
			e.nom AS nuser,
			e.prenom as puser
		FROM eld_logs AS l
		LEFT JOIN eld_eleves AS e
		ON l.iduser = e.id
		ORDER BY l.timestamp DESC")  or die( print_r( $q->errorInfo() ) ) ;
		
		$d = $q->fetchAll(PDO::FETCH_ASSOC) ;
		foreach ($d as $k => $v)
		{	$d[$k] = new logentry($v) ; }
		return $d ;
		// Récupération
		$q->closeCursor() ;
	}
	
	
	function getMonthly( $debut , $fin )
	{
		// Preparation
		$q = $this->_db->prepare("
		SELECT
			l.timestamp AS timestamp,
			l.ipaddress AS ipaddress,
			DATE_FORMAT(l.timestamp, '[ %a %d-%M ] %H:%i') AS date,
			l.action AS action,
			l.iduser AS iduser,
			l.details AS details,
			e.nom AS nuser,
			e.prenom as puser
		FROM eld_logs AS l
		LEFT JOIN eld_eleves AS e
		ON l.iduser = e.id
		WHERE l.timestamp >= :debut AND l.timestamp <= :fin
		ORDER BY l.timestamp");
		
		$q->bindValue(':debut',	$debut) ;
		$q->bindValue(':fin',	$fin) ;
		
		$q->execute() or die( print_r( $q->errorInfo() ) ) ;
		
		$d = $q->fetchAll(PDO::FETCH_ASSOC) ;
		foreach ($d as $k => $v)
		{	$d[$k] = new logentry($v) ; }
		return $d ;
		// Récupération
		$q->closeCursor() ;
	}
	
	function getOldestYear()
	{
		// Preparation
		$q = $this->_db->query("
		SELECT DATE_FORMAT( MIN(timestamp), '%Y' ) AS year
			FROM eld_logs");
		$d = $q->fetchAll(PDO::FETCH_ASSOC) ;
		return $d[0]['year'];
	}
	
}

