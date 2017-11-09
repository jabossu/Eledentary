<?php

classe('o', 'page-header') ;
display('page_reset_password', 'h1')  ;
classe('c') ;

switch ($errorType)
{
case '1':
case '5':
	alerte('missing_infos', 'warning') ;
	break;
case '2':
	alerte('matricule_invalide', 'warning') ;
	break;
case '3':
	alerte('email_invalide', 'warning') ;
	break;
case '4':
	alerte('demande_existe', 'success') ;
	break;
case '6':
	alerte('clef_invalide', 'warning') ;
	break;
case '7':
	alerte('password_invalide', 'warning') ;
	break;
case '8':
	alerte('passwords_nomatch', 'warning') ;
	break;
}

switch ($successType)
{
case '1':
	alerte('clef_envoyee') ;
	break;
case '2':
	alerte('password_changed', null, $sujet->nom() . ' ' . $sujet->prenom()) ;
	break;
}

switch ($state)
{

// Demander l'identification du compte
case '1':
	
	$f = new form() ;
	$f->input('matricule', null, 'text', $field_matri, '0000', 'Matricule') ;
	$f->input('email', null, 'email', $field_email, 'john@example.com', 'Email') ;
	$f->submit('ok') ;
	$f->output();
	break;

case '2':
	display('copiez_clef', 'p') ;
	$f = new form('classic') ;
	$f->input('clef', null, 'text', null, null, translate('clef') ) ;
	$f->submit('ok') ;
	$f->output();
	break;

case '3':
	display('change_password_for', 'p', $sujet->nom() . ' ' . $sujet->prenom() ) ;
	$f = new form(null , null, '') ;
	$f->input('motDePasse', null, 'password', null, null, 'Password') ;
	$f->input('confMotDePasse', null, 'password', null, null, 'Confirmation') ;
	$f->submit('ok') ;
	$f->output();
	break;

case '4':
	display('password_changed', 'p', $sujet->nom() . ' ' . $sujet->prenom()) ;
	echo '<a href="/?page=connexion" class="btn btn-primary">' . translate('page_connexion') . '</a>' ;
	break;
}
