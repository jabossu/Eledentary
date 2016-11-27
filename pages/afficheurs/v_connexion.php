<?php

classe('o', 'page-header') ;
display('page_connexion', 'h1' ) ;
classe('c') ;

switch ($errorType)
{
	case '1':
		alerte('bad_infos', 'warning') ;
	break;
	
	case '2':
		alerte('missing_login', 'warning' );
	break;
	
	case '3':
		alerte('incorect_login', 'warning' );
	break;
	case '4':
		alerte('incorect_login', 'warning' );
	break;
	case '5':
		alerte('approve_pending', 'info');
	break;
	case '6':
		alerte('status_banned', 'danger');
	break;
}



// Si l'utilisateur n'est pas connécté, on lui propose le formulaire.
if ( !isset( $_SESSION['profile'] ) )
{
	if ($errorType == 0)
	{	display('sign_in', 'p') ;	}	
	$form = new form(null, 'identification') ;
	$form->input('matricule', null, 'text', null, null, translate( 'matricule') ) ;
	$form->input('motDePasse', null, 'password', null, null, translate( 'motDePasse') ) ;
	$form->submit('Connexion') ;
	$form->output() ;

	echo '<a href="/?page=reset_password">' . translate('forgot_password') . '</a>';
}
// Sinon, on affiche ses détails de connexion.
else
{
	alerte( translate( 'logged_in', 'strong'), 'success', '', false) ;
	classe('o', 'col-sm-10 col-sm-push-1') ;
	echo '<ul class="liste-group">' ;
	echo '<li class="list-group-item">' . translate('nom', 'b') . ' : ' . $_SESSION['profile']->nom() . '</li>' ;
	echo '<li class="list-group-item">' . translate('prenom', 'b') . ' : ' . $_SESSION['profile']->prenom() . '</li>' ;
	echo '<li class="list-group-item">' . translate('matricule', 'b') . ' : ' . $_SESSION['profile']->matricule() . '</li>' ;
	echo '<li class="list-group-item">' . translate('annee', 'b') . ' : ' . $_SESSION['profile']->annee() . '</li>' ;
	echo '<li class="list-group-item">' . translate('nombre_soins', 'b') . ' : ' . $_SESSION['profile']->soins() . '</li>' ;
	echo '</ul>' ;
	classe('c') ;
}

