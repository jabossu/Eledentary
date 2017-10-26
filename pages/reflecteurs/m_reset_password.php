<?php

clean($_GET) ;
clean($_POST) ;

$errorType = 0 ;
/*	1 - Formulaire A mal renseigné.
*	2 - Matricule invalide
*	3 - l'email ne correspond pas
*	4 - Une demande a déja été envoyée
*	5 - Le formulaire de changement de mot de passe est incohérent
*	6 - La clef envoyée n'existe pas 
*	7 - Le mot de passe saisin n'est pas valide
*	8 - Les mots de passe ne coreespondent pas entre eux.
*/
$successType = 0 ;
/*	1 - Mail envoyé
*	
*/
$state = 0 ;
/*	1 - demander matri & mail
*	2 - l'e-mail envoyé, on propose un champ pour la clef.
*	3 - On demande les nouveaux mots de passe
*	4 - Mot de passe changé.
*/

$km = new passkeysManager($bdd) ;
$em = new elevesManager($bdd) ;

// Reçoit on une clef ?

// Si la clef a été envoyé par POST, on la passe au GET
if ( isset($_POST['clef']) AND !isset($_GET['c']) )
{
	$_GET['c'] = $_POST['clef'] ;
	 $_SERVER['REQUEST_URI'] .= '&c=' . $_POST['clef'] ;
}

// Non : on propose d'en envoyer une.
if ( !isset($_GET['c']) )
{
	// L'utilisateur a-t'il rempli le formulaire ?
	// Non, ou alors pas tout les champs
	$postAttendus = array('matricule', 'email' ) ;
	if ( missing_keys($_POST, $postAttendus) )
	{
		if (missing_keys($_POST, $postAttendus) != $postAttendus)
		{	$errorType = 1 ;	}
		$state = 1 ;
	}
	// Oui, chaque champ;
	else
	{
		// Le matri selectionné existe-t'il ?
		// oui
		if ( $em->matriculeExiste($_POST['matricule']) )
		{
			// On charge les données de l'élève.
			$sujet = $em->getId($_POST['matricule']) ;
			$sujet = $em->get($sujet) ;
			// Son mail correspond-il ?
			// oui
			if ( $sujet->email() == $_POST['email'] )
			{
				// Y a t'il déja une demande à son nom ?
				// oui
				if ( $km->demandeExiste($sujet->id()) )
				{
					$k = $km->get_with_id( $sujet->id() ) ;
					
					envoyerMail($sujet, 'Changement de mot de passe', 'password_modification', $k->value()) ; 
					$log_details = 'Ask again : send another mail' ;
					
					$state  = 2 ;
					$errorType = 4 ; 
				}
				// non : c'est une nouvelle demande
				else
				{
					$clef = uniqid() ;
					
					$k = new passkey( array( 
						"userid" => $sujet->id(),
						"value" => $clef) ) ;
					
					$km->add($k) ;
					
					envoyerMail($sujet, 'Changement de mot de passe', 'password_modification', $k->value()) ;
					$log_details = 'Send first mail' ;
					
					$state  = 2 ;
					$successType = 1 ; 
				}
				log_add($sujet->id(), 'Reset Password', $log_details) ;
			}
			// Le mail ne correspond pas.
			else
			{
				$state = 1 ;
				$errorType = 3 ;
			}
		}
		// le matricule n'existe pas.
		else
		{
			$state = 1 ;
			$errorType = 2 ;
		}
	}
	
}
// Oui : il faut vérifier que cette clef existe.
else
{
	// La clef existe-elle ?
	// Oui
	if ( $km->clefExiste($_GET['c']) )
	{
		$k = $km->get_with_value( $_GET['c'] ) ;
		$sujet = $em->get( $k->userid() ) ;
		
		$postAttendus = array( 'motDePasse', 'confMotDePasse' ) ;
		// Le formulaire a-t'il été complété correctement ?
		// Non : on l'affichera
		if ( missing_keys($_POST, $postAttendus) )
		{
			// Le formulaire est-il mal rempli, ou pas du tout ?
			if ( missing_keys($_POST, $postAttendus) != $postAttendus )
			{	$errorType = 5 ;	}
			// On affiche le formulaire
			$state = 3 ;
		}
		// Oui : on va essayer de modifier le mot de passe
		else
		{			
			// Les deux mot de passe correspondent entre eux
			// Oui
			if (  $_POST['motDePasse'] ==  $_POST['confMotDePasse'] )
			{
				// Sont ils valides ?
				$password = preg_match(	'#^[a-zA-Z0-9@_-]{6,}$#', $_POST['motDePasse'] ) ? my_encrypt($_POST['motDePasse']) : null;
				// non : il faut les redemander
				if ($password == null)
				{
					$errorType = 7 ;
					// On redemande les mot de passe
					$state = 3 ;
				}
				// Oui : on va changer le mot de passe
				else
				{
					$sujet->setMotDePasse($password) ;
					$em->updatePassword($sujet) ;
				
					$km->delete( $k );
					
					$state = 4 ;
					$successType = 2 ;
					log_add($sujet->id(), 'Password Changed', 'Successfull change') ;
					envoyerMail($sujet, 'Changement de mot de passe', 'password_modifconfirm') ;
				}
			}
			// Non : les mot de passe sont différents.
			else
			{
				$errorType = 8 ;
				// On redemande les mot de passe
				$state = 3 ;
			}
		}
	}
	// Non : on affichera une erreur.
	else
	{
		$errorType = 6 ;
		// On affiche le formulaire de mail/matri.
		$state = 2 ;
	}
}
