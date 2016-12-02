<?php

function clean(array &$donnees)
// Néttoie toutes les valeurs d'un tableau de ses balises HTML
// Protège les $_POST et $_GEt contres les injections de code
{
	foreach ($donnees as $k => $v)
	{
		$donnees[$k] = strip_tags($v) ;
	}
}

function log_add($id, $action, $details)
// Tient les logs à jours
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
// Fonction de cryptage des mots de passes par hashage
{
	/*=====================================
	!!!	CODE FONCTIONNEL APRES PHP 7
	*======================================
	
	$salt = "";

	$salt_chars = array_merge(range('A','Z'), range('a','z'), range(0,9));
	for($i=0; $i < 22; $i++)
	{
		$salt .= $salt_chars[array_rand($salt_chars)];
	}
	return crypt($input, sprintf('$2a$%02d$', $rounds) . $salt);
	*/
	
	return sha1($input) ;
	
}

function generate_key($lenght = 100)
// crée une clef de 100 caractères aléatoires, alphanumériques
{
	$lenght = ( intval($lenght) > 0 ) ? intval($lenght) : 25 ;
	
	$chars = array_merge(range('A','Z'), range('a','z'), range(0,9));
	for($i=0; $i < $lenght; $i++)
	{
		$str .= $chars[array_rand($chars)];
	}
	
	return $str ;
}
