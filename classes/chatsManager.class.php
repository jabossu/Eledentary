<?php

class chatsManager
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
	
	function add(chat $chat)
	{
		// Preparation
		$q = $this->_db->prepare("
			INSERT INTO eld_dentchat
			SET id = '', timestamp = CONVERT_TZ( NOW() ,'+00:00','+01:00') , userid = :userid, message = :message") ;
		
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
		$q = $this->_db->query("
			SELECT
				d.userid AS userid,
				DATE_FORMAT(d.timestamp, '%H:%i') AS time,
				DATE(d.timestamp) AS day,
				CONCAT( LEFT(e.prenom, 1),  '.', SUBSTR(e.nom, 1, 7) ) AS username,
				d.message AS message,
				e.annee AS anneeuser
			FROM eld_dentchat AS d
			LEFT JOIN eld_eleves AS e
			ON e.id = d.userid
			ORDER BY d.timestamp DESC
			LIMIT 0, 20") or print_r($this->_db->errorInfo());
		
		// Récupération
		//$d = array_reverse( $q->fetchAll(PDO::FETCH_ASSOC) ) ;
		$d = $q->fetchAll(PDO::FETCH_ASSOC) ;
		foreach ($d as $k => $v)
		{	$d[$k] = new chat($v) ; }
		return $d ;
		$q->closeCursor() ;
	}
	
}

