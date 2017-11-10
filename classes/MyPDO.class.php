<?php 

class MyPDO extends PDO
{
	private $_prefix ;

	public function setPrefix(string $prefix)
	{
	    $this->_prefix = $prefix;
	}
	
	public function prefix()
	{
		return $this->_prefix ;
	}
}
