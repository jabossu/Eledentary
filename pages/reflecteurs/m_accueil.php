<?php

$errorType = 0 ;

$am = new articlesManager($bdd) ;

$listeArticles = $am->getNewest() ;

$em = new elevesManager($bdd);
$pm = new patientsManager($bdd);


/* We gather datas about who is registered in our database now
*
*	$n_ means nomber of
*	$f_ means fraction of ; it's a percentage
*	
*	_pf means patients who are free
*	_pr means patients who are reserved
*	_e means students
*/
$n_pa = $pm->compter(null, $freeonly=false);
$n_pf = $pm->compter(null, $freeonly=true);
$n_pr = $n_pa - $n_pf ;
$n_e = $em->nombre() ;
$n_t = $n_pa + $n_e ;

$n_eadmin = $em->nombre('administrateur') ;

$f_pr =	$n_pr *100 / $n_t;
$f_pf =	$n_pf *100 / $n_t;
$f_e =	$n_e *100 / $n_t;

/*---------------------------------------*/

$myPatients = ( $pm->listeReserved( $_SESSION['profile']->id() ) ) > 0 ? $pm->listeReserved( $_SESSION['profile']->id() ) : 0;
$myPatients = count( $myPatients );
