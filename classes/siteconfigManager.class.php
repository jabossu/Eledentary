<?php

class siteconfigManager
{
	//	internal variables
	private $_db ;
	
	//	Constructor
	function __construct ($db)
	{
		$this->_db = $db;
	}
	
	function merge( siteconfig $old, siteconfig $new )
	{
		$parameters = get_class_methods( 'siteconfig' );
		$result = array() ;

		foreach ( $parameters as $method )
		{
			if ( method_exists($old, $method) and $method != 'hydrate' and $method != '__construct' )
			{
				if ( $new->$method() === null or $new->$method() === 'off' )
				{
					$result[$method] = $old->$method() ;
				}
				else
				{
					$result[$method] = $new->$method() ;
				}
			}
		}
		
		return new siteconfig( $result ) ;
	}
	
	function get()
	{
		$q = $this->_db->query("SELECT * FROM eld_siteconfig WHERE id = 1") or print_r($this->_db->errorInfo());
		$d = $q->fetchALL(PDO::FETCH_ASSOC) ;
		
		return new siteconfig( $d[0] ) ;
		
		$q->closeCursor() ;
	}
	
	function update( siteconfig $s )
	{
		$q = $this->_db->prepare("
			UPDATE eld_siteconfig
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
	function updateB( siteconfig $s )
	{
		$q = $this->_db->query("
			UPDATE eld_siteconfig
			SET	websiteTitle	= '1',
				websiteMoto	= 'moto',
				websiteFooter	= 'footer',
				websiteLanguage	= 'language',
				allowRegister	= 'allowRegister',
				bypassApproval	= 'bypassApproval',
				allowAnamneses	= 'allowAnamneses',
				patientLimit	= 'patientLimit'			
			") or print_r($this->_db->errorInfo());
		
		$q->closeCursor() ;
	}

}
