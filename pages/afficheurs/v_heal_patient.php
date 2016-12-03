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
display('page_heal_patients', 'h1') ;
classe('c') ;

switch ($successType)
{
	case 1:		alerte('heal_patient_ok') ; break ;
}
switch ($errorType)
{
	case 1:		alerte('bad_form_patient', 'warning') ; break ;
	case 2:		alerte('wrong_password', 'warning') ; break ;
}

switch ($mode) {
    case 'confirmed':	# La guérison est confirmée
        break;


    default: 	# La guérison n'est pas confirmée
	
	?><div class="jumbotron jumbotron-danger">
	<?php display('heal_patient_msg_title', 'h1') ; ?>
	<p class="lead"><?php display('heal_patient_msg_lead') ; ?></p>
	<hr class="my-2">
	<p><?php display('heal_patient_msg') ; ?></p>
	</div><?php
    	
    	// Profile patient
		classe('o', 'row') ;
		?><div class="col-sm-10 col-sm-offset-1 well"><table class="table table-bordered" style="font-size:1.2em;">
			<tr class="success">
				<td><?php display('nom', 'b');?></td>
				<td><?php echo $p->nom() ;?></td>
			</tr>
			<tr class="success">
				<td><?php display('prenom', 'b') ; ?></td>
				<td><?php echo $p->prenom() ;?></td>
			</tr>
			<tr class="success">
				<td><?php display('pathologie', 'b') ; ?></td>
				<td><i><?php echo $p->patho() ;?></i></td>
			</tr>
		</table></div><?php
		classe('c');
	
	// Mot de passe élève
		classe('o', 'row') ;
			$form = new form('inline', 'identification') ;
				$form->input('motDePasse', null, 'password', null, null, translate( 'motDePasse') ) ;
				$form->submit(translate('confirmation')) ;
				$form->output() ;
		classe('c');
        break;
}

