<?php

class articlesManager
{
	//	internal variables
	
	private $_db ;
	
	// Setters
	
	public function setDb($db) 				{ $this->_db = $db ; }
	
	
	// Accesseurs
	
	public function get($id)
	{
		// Préparation
		$q = $this->_db->prepare('SELECT * FROM eld_articles WHERE id = :id');
		// Attribution des valeaurs
		$q->bindValue(	':id'	,	$id) ;
		// Execution
		$q->execute()  or die( print_r( $q->errorInfo() ) ) ;
		// Récupération
		$d = $q->fetch(PDO::FETCH_ASSOC) ;
		return new article( $d ) ;
		$q->closeCursor() ;
	}
	
	public function existeId( $id)
	{
		$id = (int) $id ;
		// Préparation
		$q = $this->_db->prepare('SELECT id FROM eld_articles WHERE id = :id');
		// Attribution des valeaurs
		$q->bindValue(	':id'	,	$id) ;
		// Execution
		$q->execute()  or die( print_r( $q->errorInfo() ) ) ;
		// Récupération
		$d = $q->fetch(PDO::FETCH_ASSOC) ;
		return ( $d ) ? true : false ;
		$q->closeCursor() ;
	}
	
	
	public function add(article $post)
	{
		// Préparation
		$q = $this->_db->prepare('INSERT INTO eld_articles SET
			id = "", date = NOW(), fr_titre = :fr_titre, fr_contenu = :fr_contenu, en_titre = :en_titre, en_contenu = :en_contenu');
		// Attribution des valeurs
		$q->bindValue(	':fr_titre'		,	(string) $post->titre('fr_FR')		) ;
		$q->bindValue(	':fr_contenu'	,	(string) $post->contenu('fr_FR')		) ;
		$q->bindValue(	':en_titre'		,	(string) $post->titre('en_EN')		) ;
		$q->bindValue(	':en_contenu'	,	(string) $post->contenu('en_EN')		) ;
		// Execution
		$q->execute()  or die( print_r( $q->errorInfo() ) ) ;
		$q->closeCursor() ;
	}
	public function delete(article $post)
	{
		// Préparation
		$q = $this->_db->prepare('DELETE FROM eld_articles WHERE id = :id');
		// Attribution des valeurs
		$q->bindValue(	':id'		,	 $post->id()		) ;
		// Execution
		$q->execute()  or die( print_r( $q->errorInfo() ) ) ;
		$q->closeCursor() ;
	}
	public function update(article $post)
	{
		// Préparation
		$q = $this->_db->prepare('UPDATE eld_articles SET
		fr_titre = :fr_titre, fr_contenu = :fr_contenu, en_titre = :en_titre, en_contenu = :en_contenu WHERE id = :id');
		// Attribution des valeurs
		$q->bindValue(	':id'			,	(int) $post->id()		) ;
		$q->bindValue(	':fr_titre'		,	(string) $post->titre('fr_FR')		) ;
		$q->bindValue(	':fr_contenu'	,	(string) $post->contenu('fr_FR')		) ;
		$q->bindValue(	':en_titre'		,	(string) $post->titre('en_EN')		) ;
		$q->bindValue(	':en_contenu'	,	(string) $post->contenu('en_EN')		) ;
		// Execution
		$q->execute()  or die( print_r( $q->errorInfo() ) ) ;
		$q->closeCursor() ;
	}
	
	public function getNewest($nombre = 3)
	{
		$nombre = (int) $nombre ;
		// Préparation
		$q = $this->_db->query('SELECT * FROM eld_articles ORDER BY date DESC, id DESC LIMIT 0, 3');
		// Attribution des valeurs
		//$q->bindValue(	':nombre'	,	$nombre) ;
		// Execution
		$q->execute()  or die( print_r( $q->errorInfo() ) ) ;
		
		$d = $q->fetchAll(PDO::FETCH_ASSOC) ;
		foreach ($d as $key => $value)
		{
			$d[$key] = new article( $value ) ;
		}
		return $d ;
		$q->closeCursor() ;
	}
	
	public function getList()
	{
		// Préparation
		$q = $this->_db->query('SELECT * FROM eld_articles ORDER BY date DESC, id DESC') or die( print_r( $q->errorInfo() ) ) ;
		
		$d = $q->fetchAll(PDO::FETCH_ASSOC) ;
		foreach ($d as $key => $value)
		{
			$d[$key] = new article( $value ) ;
		}
		return $d ;
		$q->closeCursor() ;
	}
	
	
	//	Constructor
	function __construct ($db)
	{
		$this->setDb($db) ;
	}
	
}

