<?php

$errorType = 0 ;
/*
*
*/

$pm = new patientsManager($bdd) ;

clean($_POST) ;



$liste = $pm->liste($_POST['patho'], false) ;

