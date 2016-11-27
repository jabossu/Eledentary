<?php

clean($_GET);

$pm = new patientsManager($bdd) ;

if ( isset($_GET['id']) )
{
	$e_id = $_GET['id'] ;
}
else
{
	$e_id = $_SESSION['profile']->id();
}

$liste = $pm->listeReserved($e_id) ;
