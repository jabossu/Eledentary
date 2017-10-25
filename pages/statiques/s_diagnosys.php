<h1>Diagnostic</h1>

<?php

# Use this page in your developement to create tests and function
# and display them as you wish in the user interface.
# This file has been added in the gitignoer file
echo 1;

$em = new elevesManager($bdd);

$e = $em->get( $em->getId('30721') );

try 
{
	envoyerMail($e, 'Inscription réussie', 'inscription_waitconfirm') ;	
}

catch (Exception $e)
{
	echo $e;
}


echo 'end';
