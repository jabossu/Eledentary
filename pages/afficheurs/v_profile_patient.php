<?php

// ====================================
$button = function ($lien, $texte, $type, $activable=true, $othertab=false)
# 	Defining a function we will use as a shortcut
# 	to create nice bootstrap buttons later on.
# 	Takes several paramaeters to configure its appearance.
{
	$a = ($activable == false)	? 'active' : '' ; # Will the button be greyed out ? Using css class to configure that
	$o = ($othertab == true)	? ' target="_blank" ' : '' ; # Should the link open in a new tab ? Using css class
	# Now combining all datas in a single text stream to output.
	echo '<br /><a href="' . $lien . '" class="btn btn-block btn-' . $type . ' ' . $a . '"' . $o . '>' . translate($texte) . "</a>\n";
};
// ==================================== 

// Printing page header
classe('o', 'page-header') ;
display('page_profile_patients', 'h1') ;
classe('c') ;

switch ($successType)
# Printing various success notifications depending of what was done.
# $successType was set in the reflector page
{
	case 1:		alerte('register_patient_ok') ; break ;
	case 2:		alerte('update_patient_ok') ; break ;
	case 3:		alerte('delete_patient_ok') ; break ;
	case 4:		alerte('reserve_patient_ok') ; break ;
	case 5:		alerte('free_patient_ok') ; break ;
}

switch ($errorType)
# Printing various error notifications depending of what was done.
# $errortype was set in the reflector page
{
	case 1:		alerte('bad_form_patient', 'warning') ; break ;
	case 2:		alerte('bad_infos_patient', 'warning') ; break ;
	case 3:		alerte('patient_hasmedic', 'warning') ; break ;
	case 4:		alerte('medic_haspatient', 'warning') ; break ;
	case 5:		alerte('cannot_freepatient', 'warning') ; break ;
}

classe('o', 'row') ; #start a new row

classe('o', 'col-sm-8') ; # start left collumn

	# beggin a new form which will display the patient datas
	$f = new form('classic', translate('patient_profile') ) ;

	# first section of patient profile
	$f->legend( translate('info_patient') );
		$f->input('nom', translate('nom'), 'text', $p->nom(), 'Name' );
		$f->input('prenom', translate('prenom'), 'text', $p->prenom(), 'Forname');
		$f->input('cnp', translate('cnp'), 'tel', $p->cnp(), 'C.N.P');
	
	# second section of patient profile
	$f->legend( translate('info_pathologie') );
		# load the list of all pathologies avaibale to selection
		$qm = new pathologiesManager($bdd) ; 
			$l = $qm->liste() ; $choix = array() ; #generate the list
			foreach ( $l as $v ) # go through the list to get names
			{	$choix[$v->id()] = $v->nom() ; 		}
		$f->liste('id_patho', translate('pathologie'), $choix, $p->id_patho() ) ;
		
		$f->input('dent', translate('dent'), 'tel', $p->p_dent(), 'ex: XX');
		$f->input('details', translate('details'), 'text', $p->details());
	
	# third section of patient profile
	$f->legend( translate('info_contact') );
		if ( null !== $p->soignant() or null == $p->id() ) {
			$f->input('telephone', null, 'tel', $p->telephone(), 'ex: 0755000001', '<span class="glyphicon glyphicon-phone-alt"></span>');
			$f->input('email', null, 'email', $p->email(), 'ex: john@example.com', '<span class="glyphicon glyphicon-envelope"></span>');
			$f->input('addresse', null, 'text', $p->addresse(), 'ex: 1 strada napoca, 400000 Cluj-Napoca', '<span class="glyphicon glyphicon-home"></span>');
		}
		else {
			alerte('patient_datas_hidden', 'warning', 'b');
			$f->texte( translate('patient_datas_hidden') );
		}
		
	
	$f->submit( translate('register') ) ; # submit button
	
	#print out the form to html
	$f->output() ;
	
classe('c'); #close the column

classe('o', 'col-sm-4') ; #start a new column, at right
	
	# print out the menu avaiable depending of the user status.
	
	if ($_SESSION['profile']->statut() == 'administrateur' )
	// Only admin have the right to delete a patient
	{
		// First action : delete patient datas
		$button('?page=profile_patient&id=' . $p->id() . '&action=delete', 'action_supprimer', 'danger');
	}
	
	// Second action : toogle the patient status : is he rerved or not ?
	if ( $pm->isFree($p) )
	// If he is free : allow everyone to reserve him
	{
		$button('?page=profile_patient&id=' . $p->id() . '&action=reserve', 'action_reserve', 'success');
	}
	else
	// If not : only the legitimate user and admins can manage him.
	{
		if ( $p->soignant() == $_SESSION['profile']->id() or $_SESSION['profile']->statut() == 'administrateur' )
		{
			$button('?page=profile_patient&id=' . $p->id() . '&action=free', 'action_free', 'success');
			$button('?page=heal_patient&id=' . $p->id(), 'action_heal', 'success');
		}
	}
	
	// Shortcut to patient list page
	$button('?page=patients', 'page_patients', 'primary');
	
classe('c'); # end the right column

classe('c'); # end the row

unset($button) ; # unset the button function to free up memory
