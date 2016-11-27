<?php

classe('o', 'page-header') ;
display('page_profile_patients', 'h1') ;
classe('c') ;

switch ($successType)
{
	case 1:		alerte('register_patient_ok') ; break ;
	case 2:		alerte('update_patient_ok') ; break ;
}

switch ($errorType)
{
	case 1:		alerte('bad_form_patient', 'warning') ; break ;
	case 2:		alerte('bad_infos_patient', 'warning') ; break ;
}

$patho_default = 

$f = new form('classic', translate('patient_profile') ) ;
	$f->legend( translate('info_patient') );
		$f->input('nom', translate('nom'), 'text', $p->nom(), 'Name' );
		$f->input('prenom', translate('prenom'), 'text', $p->prenom(), 'Forname');
		$f->input('cnp', translate('cnp'), 'tel', $p->cnp(), 'C.N.P');
	$f->legend( translate('info_pathologie') );
		$f->input('details', translate('details'), 'text', $p->details());
	$f->legend( translate('info_contact') );
		$f->input('telephone', null, 'tel', $p->telephone(), 'ex: 0755000001', '<span class="glyphicon glyphicon-phone-alt"></span>');
		$f->input('email', null, 'email', $p->email(), 'ex: john@example.com', '<span class="glyphicon glyphicon-envelope"></span>');
		$f->input('addresse', null, 'text', $p->addresse(), 'ex: 1 strada napoca, 400000 Cluj-Napoca', '<span class="glyphicon glyphicon-home"></span>');
$f->submit( translate('register') ) ;
$f->output() ;
