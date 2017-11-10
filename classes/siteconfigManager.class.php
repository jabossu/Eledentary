<?php

/**
*	Classe chargeant et manipulant la configuration du site
*
*
**/

class siteconfigManager
{
	//	internal variables
	private $_db ;
	private	$_table;
	
	//	Constructor
	function __construct ($db)
	{
		$this->_db = $db;
		$this->table = 'siteconfig' ;
	}
	
	function merge( siteconfig $old, siteconfig $new )
	// Permet de ne pas perdre de parametre si la nouvelle config est incomplete
	// Utilise la vielle config pour preserver les parametres oublies.
	{
		$parameters = get_class_methods( 'siteconfig' );
		// Recuperation de tout les parametres possibles de la configuration
		$result = array() ;

		foreach ( $parameters as $method )
		{
			if ( method_exists($old, $method)
				and $method != 'hydrate'
				and $method != '__construct'
				and ! preg_match( "#^set_*#", $method) )
			{
				if ( $new->$method() === null )
				// SI le parametre n'existe pas dans la nouvelle config
				{
					// On le charge d'apres l'encienne
					$result[$method] = $old->$method() ;
				}
				else
				{
					// Si il existe on utilise le plus recent
					$result[$method] = $new->$method() ;
				}
			}
		}
		
		return new siteconfig( $result ) ;
	}
	
	function get()
	{
		$q = $this->_db->prepare("SELECT * FROM :tablename WHERE id = 1") 
			or print_r($this->_db->errorInfo());
			
		$q->bindValue( ':tablename', $this->_db->prefix() . $this->_table) ;
		
		$q->execute()  or die( print_r( $q->errorInfo() ) ) ;
		$d = $q->fetchALL(PDO::FETCH_ASSOC) ;
		
		return new siteconfig( $d[0] ) ;
		
		$q->closeCursor() ;
	}
	
	function update( siteconfig $s )
	{
		$q = $this->_db->prepare("
			UPDATE :tablenamesiteconfig
			SET	websiteTitle	= :title,
				websiteMoto	= :moto,
				websiteFooter	= :footer,
				websiteLanguage	= :language,
				allowRegister	= :allowRegister,
				bypassApproval	= :bypassApproval,
				allowAnamneses	= :allowAnamneses,
				patientLimit	= :patientLimit			
			") or print_r($this->_db->errorInfo());
		
		// Attribution des valeurs
		$q->bindValue(	':title'		,	$s->websiteTitle()	) ;
		$q->bindValue(	':moto'			,	$s->websiteMoto()		) ;
		$q->bindValue(	':footer'		,	$s->websiteFooter()	) ;
		$q->bindValue(	':language'		,	$s->websiteLanguage()	) ;
		$q->bindValue(	':allowRegister'	,	$s->allowRegister()	) ;
		$q->bindValue(	':bypassApproval'	,	$s->bypassApproval()	) ;
		$q->bindValue(	':allowAnamneses'	,	$s->allowAnamneses()	) ;
		$q->bindValue(	':patientLimit'		,	$s->patientLimit()	) ;
		
		$q->execute()  or die( print_r( $q->errorInfo() ) ) ;
		$q->closeCursor() ;
	}
}
