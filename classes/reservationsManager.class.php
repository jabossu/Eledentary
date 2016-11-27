<?php

class reservationsManager
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
	
	public function add(reservation $r)
	{
		// Preparation
		$q = $this->_db->prepare("
			INSERT INTO eld_reservation SET
				id = '',
				idEleve = :idEleve,
				idPatient = :idPatient,
				idPatho = :idPatho,
				enregistrement = NOW(),
				confirme = 0") ;
		
		// Attribution des valeurs
		$q->bindValue(':idEleve', $r->idEleve());
		$q->bindValue(':idPatient', $r->idPatient());
		$q->bindValue(':idPatho', $r->idPatho());
		
		// Execution
		$q->execute() or die( print_r( $this->_db->errorInfo() ) )  ;
		
		// Récupération
		return true ;
		$q->closeCursor() ;
	}
	
	public function free(reservation $r)
	{
		$q = $this->_db->prepare("
			DELETE FROM eld_reservation
			WHERE id = :id") ;
		
		$q->bindValue(':id', $r->id() );
		
		$q->execute() or die( print_r( $this->_db->errorInfo() ) )  ;
		$q->closeCursor() ;
	}
	
	public function confirm(reservation $r)
	{
		$q = $this->_db->prepare("
			UPDATE eld_reservation SET
				confirme = 1
			WHERE id = :id") ;
		
		$q->bindValue(':id', $r->id() );
		
		$q->execute() or die( print_r( $this->_db->errorInfo() ) )  ;
		$q->closeCursor() ;
	}
	
	public function unconfirm(reservation $r)
	{
		$q = $this->_db->prepare("
			UPDATE eld_reservation SET
				confirme = 0
			WHERE id = :id") ;
		
		$q->bindValue(':id', $r->id() );
		
		$q->execute() or die( print_r( $this->_db->errorInfo() ) )  ;
		$q->closeCursor() ;
	}
	
	public function update(reservation $r)
	{
		$q = $this->_db->prepare("
			UPDATE eld_reservation SET
				id = '',
				idEleve = :idEleve,
				idPatient = :idPatient,
				idPatho = :idPatho,
				enregistrement = NOW()
			WHERE id = :id") ;
		
		$q->bindValue(':id', $r->id() );
		$q->bindValue(':idEleve', $r->idEleve());
		$q->bindValue(':idPatient', $r->idPatient());
		$q->bindValue(':idPatho', $r->idPatho());
		
		$q->execute() or die( print_r( $this->_db->errorInfo() ) )  ;
		$q->closeCursor() ;
	}
	
	public function postpone(reservation $r)
	{
		$q = $this->_db->prepare("
			UPDATE eld_reservation SET
				enregistrement = NOW()
			WHERE id = :id") ;
		
		$q->bindValue(':id', $r->id() );
		
		$q->execute() or die( print_r( $this->_db->errorInfo() ) )  ;
		$q->closeCursor() ;
	}
	
	public function is_reserved($p)
	{
		$q = $this->_db->prepare("
			SELECT id
			FROM eld_reservation
			WHERE idPatient = :idPatient") or die( print_r( $this->_db->errorInfo() ) ) ;
	
		// Attribution des valeurs
		$q->bindValue(':idEleve', $e );
	
		// Execution
		$q->execute() or die( print_r( $q->errorInfo() ) );

		// Récupération
		$d = $q->fetch(PDO::FETCH_ASSOC) ;
		$r = ( $d != false )		? true	: false	;
		return $r ;
		$q->closeCursor() ;
	}
	
	public function existe(patient $p=null, eleve $e=null)
	{
		if ( $p != null and $e != null )
		{
			$q = $this->_db->prepare("
				SELECT id
				FROM eld_reservation
				WHERE
					idEleve = :idEleve AND idPatient = :idPatient") or die( print_r( $this->_db->errorInfo() ) ) ;
		
			// Attribution des valeurs
			$q->bindValue(':idEleve', $e );
			$q->bindValue(':idPatient', $p );
		
			// Execution
			$q->execute() or die( print_r( $q->errorInfo() ) );

			// Récupération
			$d = $q->fetch(PDO::FETCH_ASSOC) ;
			$r = ( $d != false )		? true	: false	;
			return $r ;
			$q->closeCursor() ;
		}
		else
		{
			return false ;
		}
	}
	
	public function match($id_p, $id_e)
	{
		$id_p = intval($id_p);
		$id_e = intval($id_e);
		
		$pm = new patientsManager($this->_db) ;
		$em = new elevesManager($this->_db) ;
		
		if ( $pm->existe($id_p) and $em->idExiste($id_e) and $this->existe($id_p, $id_e) )
		{
			// Preparation
			$q = $this->_db->prepare("
				SELECT
					r.id AS id,
					r.enregistrement AS enregistrement,
					r.confirme AS confirme,
					p.id AS idPatient,
					CONCAT( p.nom, ' ', p.prenom) AS nomPatient,
					e.id AS idEleve,
					CONCAT( e.nom, ' ', e.prenom) AS nomEleve
				FROM eld_reservation AS r
				LEFT JOIN eld_patients AS p
					ON r.idPatient = p.id
				LEFT JOIN eleves AS e
					ON r.idEleve = e.id
				WHERE
					e.id = :idEleve AND p.id = :idPatient") or die( print_r( $this->_db->errorInfo() ) ) ;
		
			// Attribution des valeurs
			$q->bindValue(':idEleve', $id_e );
			$q->bindValue(':idPatient', $id_p );
		
			// Execution
			$q->execute() or die( print_r( $q->errorInfo() ) );

			// Récupération
			$d = $q->fetch(PDO::FETCH_ASSOC) ;
			$d = new reservation($d) ;
			return $d ;
			$q->closeCursor() ;
		}
		else
		{
			return new reservation( array() ) ;
		}
	}
	
}

