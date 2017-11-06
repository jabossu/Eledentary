<h1>Diagnostic</h1>

<?php

# Use this page in your developement to create tests and function
# and display them as you wish in the user interface.
# This file has been added in the gitignoer file



#envoyerMail($_SESSION['profile'], 'Compte approuvé', 'inscription_confirmed') ;

$template = "inscription_confirmed";
$object = "Eledentary" ;
$options = array( 'NOM' => 'Bossu', "PRENOM" => "Jacques-Alexandre") ;

//show( scandir("ressources/mails/") );

echo compile_mail($template, $object, $options) ;

