<?php

$em = new elevesManager( $bdd ) ;
$pm = new patientsManager( $bdd ) ;

$p = $pm->get(28) ;
$e = $em->get(11);

show ($_SESSION);

?>
