<?php

$errorType = 0 ;
$successType = 0 ;
/*
*	1 = L'eleve n'existe pas.
*	2 = Le post rempli est incomplet.
*	3 = champs incorrects
*	4 = formulaire corrompu
*	5 = action invalide
*/

clean($_POST);
clean($_GET);

$getAttendues = array( 'ban', 'delete', 'approve', 'make_admin' ) ;
$postAttendues = array( 'nom', 'prenom', 'email', 'telephone', 'annee', 'matricule' ) ;

$em = new elevesManager($bdd) ;
$id = $_GET['id'] ;
if ( $em->idExiste($id) == false ) 
{
	$errorType = 1 ;
}
else
{
	$sujet = $em->get($id) ;
	
	// Il ne manque aucune clef : le post a été envoyé.
	if ( !missing_keys( $_POST, $postAttendues ) )
	{
		// Il manque des valeurs
		if (contains_null($_POST))
		{
			$errorType = 2 ;
		}
		// Tout les champs sont remplis.
		else
		{
			$donnees['nom']		=	preg_match(	'#^[a-z -]{2,}$#i'						, $_POST['nom']			) ? strtoupper($_POST['nom'])		: null;
			$donnees['prenom']	=	preg_match(	'#^[a-z-]{2,}$#i'						, $_POST['prenom']		) ? strtoupper($_POST['prenom'])	: null;
			$donnees['matricule']	=	preg_match(	'#^[0-9]{4,5}$#'						, $_POST['matricule']	) ? $_POST['matricule']				: null;
			$donnees['email']	=	preg_match(	'#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#'	, $_POST['email']		) ? $_POST['email'] 				: null;
			$donnees['telephone']=	preg_match(	'#^(0|\+40)[-. ]?7[0-9]{2}([-. ]?[0-9]{3}){2}$#', $_POST['telephone']	) ? $_POST['telephone']				: null;
			$donnees['annee']	=	preg_match(	'#^[3-6]$#', $_POST['annee']	) ? (int) $_POST['annee'] : null ;
			
			// Certains champs étaient incorrects
			if (contains_null($donnees) )
			{
				$errorType = 3 ;
			}
			// Toutes les infos sont bonnes
			else
			{
				$e = new eleve($donnees) ;
				$e->setStatut ( $sujet->statut() ) ;
				$e->setId ( $sujet->id() ) ;
				$em->update( $e ) ;
				$successType = 1 ;
				log_add($_SESSION['profile']->id(), 'Profile Edited', 'changed infos about '. $e->nom() . ' ' . $e->prenom()  ) ;
			}
		}
	}
	// Le post est incomplet = anormal
	elseif ( missing_keys( $_POST, $postAttendues ) != $postAttendues)
	{
		$errorType = 4 ;
	}
	// Le post est vide.
	else
	{
		// L'action est définie
		if ( isset( $_GET['action'] ) )
		{
			// L'action est une action valide
			if ( in_array( $_GET['action'], $getAttendues ) )
			{
				switch ($_GET['action'])
				{
					case 'ban':
						$em->ban($sujet);
						envoyerMail($sujet, 'Compte banni', 'account_banned') ;
                    	log_add($_SESSION['profile']->id(), 'Role changed', 'Account #' . $sujet->id() . ' named ' . $sujet->nom() . ' ' . $sujet->prenom() . ' was banned') ;
						$successType = 4;
					break;
					case 'approve':
						$em->approve($sujet);
						envoyerMail($sujet, 'Compte approuvé', 'inscription_confirmed') ;
                    	log_add($_SESSION['profile']->id(), 'Role changed', 'Account #' . $sujet->id() . ' named ' . $sujet->nom() . ' ' . $sujet->prenom() . ' was approved') ;
						$successType = 2;
					break;
					case 'delete':
						$em->delete($sujet);
						envoyerMail($sujet, 'Compte supprimé', 'account_deleted') ;
                    	log_add($_SESSION['profile']->id(), 'Role changed', 'Account #' . $sujet->id() . ' named ' . $sujet->nom() . ' ' . $sujet->prenom() . ' was deleted') ;
						$successType = 3;
						//$sujet = new eleve( array() ) ;
					break;
					case 'make_admin':
						$em->chadmin($sujet);
						envoyerMail($sujet, 'Adminisation', 'account_admin') ;
                    	log_add($_SESSION['profile']->id(), 'Role changed', 'Account #' . $sujet->id() . ' named ' . $sujet->nom() . ' ' . $sujet->prenom() . ' became Admin') ;
						$successType = 5;
					break;
				}
			}
			// L'action n'existe pas.
			else
			{
				$errorType = 5 ;
			}
		}
	}
	if ( $successType == 3 )
	{
		// do nothing 
	}
	else
	{
		$sujet = $em->get($id) ;
	}
}
