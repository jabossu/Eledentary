<?php

class pathologie
{
	//	internal variables
	
	private $_id ;
	private $_nom_fr_FR ;
	private $_nom_en_EN ;
	private $_annees ;
	private $_details_fr_FR ;
	private $_details_en_EN ;

	// Accesseurs
	
	public function id() 		{ return $this->_id ; }
	public function nom( $langue=null ) 		
	{
		if ( in_array($langue, array('fr_FR', 'en_EN'), true) )
		{
			if ( $langue == 'fr_FR' )
			{
				return $this->_nom_fr_FR ;
			}
			else
			{
				return $this->_nom_en_EN ;
			}
		}
		else
		{
			if ( $GLOBALS['_SESSION']['langue'] == 'fr_FR' )
			{
				return $this->_nom_fr_FR ;
			}
			else
			{
				return $this->_nom_en_EN ;
			}
		}		
	}
	public function details( $langue=null ) 		
	{
		if ( in_array($langue, array('fr_FR', 'en_EN'), true) )
		{
			if ( $langue == 'fr_FR' )
			{
				return $this->_details_fr_FR ;
			}
			else
			{
				return $this->_details_en_EN ;
			}
		}
		else
		{
			if ( $GLOBALS['_SESSION']['langue'] == 'fr_FR' )
			{
				return $this->_details_fr_FR ;
			}
			else
			{
				return $this->_details_en_EN ;
			}
		}	
	}
	public function p_annees() 	{ return $this->_annees ; }
	public function annees()
	{
		$r = explode( ',' , $this->_annees ) ;
		return $r ;
	}
	
	// Setters
	
	public function setId($id)
	{
		$v = (int) $id ;
		if ( $v != 0 )
		{
			$this->_id = $v ;
			return true ;
		}
		else
		{
			$this->_id = null ;
			return false ;
		}
	}
	
	
	public function setNom_fr_FR($v)
	{
		if ( preg_match("#([a-z _-])+#i", $v) )
		{
			$this->_nom_fr_FR = ucfirst(strtolower($v)) ;
			return true ;
		}
		else
		{
			$this->_nom_fr_FR = null ;
			return false ;
		}
	}
	public function setNom_en_EN($v)
	{
		if ( preg_match("#([a-z _-])+#i", $v) )
		{
			$this->_nom_en_EN = ucfirst(strtolower($v)) ;
			return true ;
		}
		else
		{
			$this->_nom_en_EN = null ;
			return false ;
		}
	}
	
	public function setAnnees($v)
	{
		if ( is_array($v) )
		{
			$str = '' ;
			foreach ($v as $value)
			{
				$value = (int) $value ;
				if ($value >= 3 AND $value <= 6)
				{
					$str .= ',' . $value  ;
				}
			}
			$str = substr($str, 1);
			$this->_annees = $str ;
		}
		else
		{
			if ( preg_match('#^[3-6](,[3-6])*$#', $v ) )
			{
				$this->_annees = $v ;
			}
			else
			{
				$this->_annees = null ;
			}
		}
		
	}
	
	public function setDetails_fr_FR($v) 
	{
		$this->_details_fr_FR = $v ;
	}
	public function setDetails_en_EN($v) 
	{
		$this->_details_en_EN = $v ;
	}
	
	public function hydrate(array $donnees)
	{
		foreach ($donnees as $key => $value)
		{
			// On récupère le nom du setter correspondant à l'attribut.
			$method = 'set'.ucfirst($key);
			
			// Si le setter correspondant existe.
			if (method_exists($this, $method))
			{
				// On appelle le setter.
				$this->$method($value);
			}
		}
	}
	// ...
	
	//	Constructor
	function __construct (array $datas)
	{
		$this->hydrate($datas) ;
	}

}

