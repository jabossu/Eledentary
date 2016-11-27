<?php


$cm = new chatsManager($bdd) ;
clean($_POST) ;
$parametresAttendus = array("message") ;

if ( missing_keys($_POST, $parametresAttendus) == false )
{
	$c = new chat( 
	array(
		"userid" => $_SESSION['profile']->id() ,
		"message" => $_POST['message']	) );
	$cm->add($c) ;
}
