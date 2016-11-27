<?php

// ====================================
$button = function ($lien, $texte, $type, $activable=true, $othertab=false)
{
	$a = ($activable == false)	? 'active' : '' ;
	$o = ($othertab == true)	? ' target="_blank" ' : '' ;
	echo '<br /><a href="' . $lien . '" class="btn btn-block btn-' . $type . ' ' . $a . '"' . $o . '>' . translate($texte) . "</a>\n";
};
// ==================================== 


classe('o', 'page-header') ;
display('page_profile', 'h1') ;
classe('c') ;

switch ($successType)
{
	case '1':
		alerte('success_edit', 'success') ;
	break;
	case '2':
		alerte('success_approve', 'success') ;
	break;
	case '3':
		alerte('success_delete', 'warning') ;
	break;
	case '4':
		alerte('success_ban', 'warning') ;
	break;
	case '5':
		alerte('success_chadmin', 'success') ;
	break;
}

switch ($errorType)
{
	case 1:
		echo 'No such profile nor student' ;
		break;
}

if ( $errorType == 0  and $successType != 3 )
{
		classe('o', 'row') ;
		classe('o', 'col-sm-9') ;	
	
		$form = new form('horizontal' ) ;
	
		$form->input('nom', translate('nom'), null, $sujet->nom() ) ;
		$form->input('prenom', translate('prenom'), null, $sujet->prenom() ) ;
		$form->input('matricule', translate('matricule'), null, $sujet->matricule() ) ;
		$form->input('status', translate('statut'), 'fake', translate($sujet->statut()) ) ;
		$form->input('email', translate('email'), 'email', $sujet->email() );
		$form->input('telephone', translate('telephone'), 'tel', $sujet->telephone() );
		$form->liste('annee', translate('annee'), array(
			'3'	=>	translate('3'),
			'4'	=>	translate('4'),
			'5'	=>	translate('5'),
			'6'	=>	translate('6')), $sujet->annee()  );
	
		$form->submit( translate('save') );
	
		$form->output() ;
		if ($_SESSION['profile']->id() == $id )
		{
			$button('?page=reset_password', 'page_reset_password', 'success' );
		}
		classe('c') ;
	
		classe('o', 'col-sm-3') ;
		if ($_SESSION['profile']->statut() == 'administrateur' )
		{
			$button('?page=profile&id=' . $id . '&action=approve', 'action_approuver', 'success', ($sujet->statut() == 'approuve') ? false : true );
			$button('?page=profile&id=' . $id . '&action=ban', 'action_bannir', 'warning', ($sujet->statut() == 'banni') ? false : true );
			$button('?page=profile&id=' . $id . '&action=delete', 'action_supprimer', 'danger');
			$button('?page=profile&id=' . $id . '&action=make_admin', 'action_adminiser', 'primary', ($sujet->statut() == 'administrateur') ? false : true );
			$button('mailto:' . $sujet->email() , 'action_email', 'primary', true, true );
			$button('?page=eleves', 'page_eleves', 'primary' );
		}
		else
		{
			$button('?page=contact', 'page_contact', 'primary');
		}
		classe('c') ;
		classe('c') ;
		unset($button) ;
}
