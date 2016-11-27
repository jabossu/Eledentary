<?php

function clean(array &$donnees)
{
	foreach ($donnees as $k => $v)
	{
		$donnees[$k] = strip_tags($v) ;
	}
}

function log_add($id, $action, $details)
{
    $l = array ( 
        'iduser' => intval( $id) ,
        'details' => wordwrap($details, 60, "<br/>\t"),
        'action' => wordwrap($action, 30, "<br/>\n") ) ;

    $lm = new logManager($GLOBALS['bdd']) ;
    $l = new logentry($l) ;
    $lm->add( $l ) ;

}


function better_crypt($input, $rounds = 13)
{
	/*
	$salt = "";

	$salt_chars = array_merge(range('A','Z'), range('a','z'), range(0,9));
	for($i=0; $i < 22; $i++)
	{
		$salt .= $salt_chars[array_rand($salt_chars)];
	}
	return crypt($input, sprintf('$2a$%02d$', $rounds) . $salt);*/
	
	return sha1($input) ;
	
}

function generate_key($lenght = 100)
{
	$lenght = ( intval($lenght) > 0 ) ? intval($lenght) : 25 ;
	
	$chars = array_merge(range('A','Z'), range('a','z'), range(0,9));
	for($i=0; $i < $lenght; $i++)
	{
		$str .= $chars[array_rand($chars)];
	}
	
	return $str ;
}
