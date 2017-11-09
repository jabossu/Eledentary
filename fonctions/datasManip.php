<?php

function clean(array &$donnees)
// Néttoie toutes les valeurs d'un tableau de ses balises HTML
// Protège les $_POST et $_GEt contres les injections de code
{
	foreach ($donnees as $k => $v)
	{
		$donnees[$k] = htmlspecialchars($v) ;
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

function my_encrypt( string $input )
# This function is just here to encapsulate the default PHP hashing function
# I do this to make it easier later on to update password hashing as security
# standards evolve.
{
	/*	Setting the salt manually is now deprecated
	
	$salt = openssl_random_pseudo_bytes( 22 ); #Let us have a salt !
	$options = array( 'cost' => 11, 'salt' => $salt, );*/
	
	return password_hash( $input, PASSWORD_DEFAULT);
}

function my_decrypt( $password, $hash)
# This function is just here to encapsulate the default PHP hashing function
# I do this to make it easier later on to update password hashing as security
# standards evolve.
{
	$result = ( password_verify( $password, $hash ) ) ? true : false ;

	return $result ; # Return a boolean
}
