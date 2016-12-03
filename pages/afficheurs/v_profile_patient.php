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
display('page_profile_patients', 'h1') ;
classe('c') ;

switch ($successType)
{
	case 1:		alerte('register_patient_ok') ; break ;
	case 2:		alerte('update_patient_ok') ; break ;
	case 3:		alerte('delete_patient_ok') ; break ;
	case 4:		alerte('reserve_patient_ok') ; break ;
	case 5:		alerte('free_patient_ok') ; break ;
}

switch ($errorType)
{
	case 1:		alerte('bad_form_patient', 'warning') ; break ;
	case 2:		alerte('bad_infos_patient', 'warning') ; break ;
	case 3:		alerte('patient_hasmedic', 'warning') ; break ;
	case 4:		alerte('medic_haspatient', 'warning') ; break ;
	case 5:		alerte('cannot_freepatient', 'warning') ; break ;
}

classe('o', 'row') ;

classe('o', 'col-sm-8') ;
	$f = new form('classic', translate('patient_profile') ) ;
	$f->legend( translate('info_patient') );
		$f->input('nom', translate('nom'), 'text', $p->nom(), 'Name' );
		$f->input('prenom', translate('prenom'), 'text', $p->prenom(), 'Forname');
		$f->input('cnp', translate('cnp'), 'tel', $p->cnp(), 'C.N.P');
	$f->legend( translate('info_pathologie') );
		$qm = new pathologiesManager($bdd) ;
			$l = $qm->liste() ; $choix = array() ;
			foreach ( $l as $v )
			{	$choix[$v->id()] = $v->nom() ; 		}
		$f->liste('id_patho', translate('pathologie'), $choix, $p->id_patho() ) ;
		$f->input('dent', translate('dent'), 'tel', $p->p_dent(), 'ex: XX');
		$f->input('details', translate('details'), 'text', $p->details());
	$f->legend( translate('info_contact') );
		$f->input('telephone', null, 'tel', $p->telephone(), 'ex: 0755000001', '<span class="glyphicon glyphicon-phone-alt"></span>');
		$f->input('email', null, 'email', $p->email(), 'ex: john@example.com', '<span class="glyphicon glyphicon-envelope"></span>');
		$f->input('addresse', null, 'text', $p->addresse(), 'ex: 1 strada napoca, 400000 Cluj-Napoca', '<span class="glyphicon glyphicon-home"></span>');
	$f->submit( translate('register') ) ;
	$f->output() ;
classe('c');

classe('o', 'col-sm-4') ;
	if ($_SESSION['profile']->statut() == 'administrateur' and isset( $_GET['id'] ) and $pm->existe($_GET['id']) )
	{
		$button('?page=profile_patient&id=' . $p->id() . '&action=delete', 'action_supprimer', 'danger');
		if ( $pm->isFree($p) )
		{
			$button('?page=profile_patient&id=' . $p->id() . '&action=reserve', 'action_reserve', 'success');
		}
		else
		{
			if ( $p->soignant() == $_SESSION['profile']->id() or $_SESSION['profile']->statut() == 'administrateur' )
			{
				$button('?page=profile_patient&id=' . $p->id() . '&action=free', 'action_free', 'success');
				$button('?page=heal_patient&id=' . $p->id(), 'action_heal', 'success');
			}
		}
		$button('?page=patients', 'page_patients', 'primary');
		unset($button) ;
	}
classe('c');

classe('c');
