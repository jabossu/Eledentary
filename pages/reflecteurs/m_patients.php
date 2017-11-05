<?php

$errorType = 0 ;
/*
*
*/

$pm = new patientsManager($bdd) ;

clean($_POST) ;


$patho = ( isset($_POST['patho']) ) ? $_POST['patho'] : null ;
$liste = $pm->liste($patho, false) ;

