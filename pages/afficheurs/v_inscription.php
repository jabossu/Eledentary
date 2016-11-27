<?php

classe('o', 'page-header') ;
display('page_inscription', 'h1' ) ;
classe('c') ;

switch ($errorType)
{
	case 0:		alerte('success', 'success') ;	break;
	case 1:		display('new_page', 'p') ; echo '<br/>' ;	break;
	case 2:		alerte('bad_infos', 'danger') ;	break;
	case 3:
		$chaine = translate('missing_infos', 'strong') ;
		foreach (contains_null($_POST) as $key => $value)
		{
			$chaine = $chaine . ' ; ' . translate($value) ;
		}
		alerte($chaine, 'warning', '', false) ;
	break;
	
	case 4:
		$chaine = translate('incorect_infos', 'strong') ;
		foreach (contains_null($donnees) as $key => $value)
		{
			$chaine = $chaine . translate($value) . ' ; ';
		}
		alerte($chaine, 'danger', '', false) ;
	break;
	
	case 5:
		alerte('matricule_double', 'warning') ;
	break;
	
	case 6:
		alerte('registration_forbiden', 'danger') ;
	break;
}

echo "<br/>\n" ;

if ($errorType != 0)
{
	
	$form = new form('horizontal') ;
	
	$form->legend(translate('inscription')) ;
	$form->input('nom', translate('nom'), 						'text', $donnees['nom'], 'ADAMS') ;
	$form->input('prenom', translate('prenom'), 				'text', $donnees['prenom'], 'DOUGLAS') ;
	$form->input('matricule', translate('matricule'), 			'text', $donnees['matricule'], 'xxxx') ;
	$form->input('motDePasse', translate('motDePasse'), 		'password', null) ;
	$form->input('confMotDePasse', translate('confMotDePasse'), 'password', null) ;
	$form->input('email', translate('email'), 					'email',  $donnees['email'], 'douglas.adams@gmail.com');
	$form->input('telephone', translate('telephone'), 			'tel',  $donnees['telephone'], '0750000001' );
	$form->liste('annee', translate('annee'), array(
		'3'	=>	translate('3'),
		'4'	=>	translate('4'),
		'5'	=>	translate('5'),
		'6'	=>	translate('6')), $donnees['annee'] );
	
	$form->submit( translate('sign_up') );
	
	$form->output() ;
}

?>
