<?php

if ( $siteconfig->allowRegister() == 'off' )
{
	$errorType = 6;
	exit('Inscription forbiden');
}
else
{
	$errorType = 0 ;
}

/*	0 = Formulaire rempli et correcte
*	1 = Formulaire  vierge
*	2 = Formulaire incohérent
*	3 = Formulaire incomplet
*	4 = Des valeurs sont incorectes
*	5 = Le matricule est double !
*/

$em = new elevesManager($bdd) ;

// Liste des parametre que l'on s'attend à recevoir.
$parametresAttendus = array('nom', 'prenom', 'matricule', 'motDePasse', 'email', 'telephone', 'annee');

// On "purifie" les infos reçue avec un strip_tags
clean($_POST) ;

// Si il manque des clefs, ou bien le POST n'est pas rempli du tout, ou bien il est incomplet.
if ( missing_keys($_POST, $parametresAttendus) )
{
	// Il manque toutes les clefs : la page est affichée pour la première fois
	if ( missing_keys($_POST, $parametresAttendus) == $parametresAttendus )
	{
		$errorType = 1 ;
	}
	// Il ne manque que certaines clefs : le POST est incohérent.
	else
	{
		$errorType = 2 ;
	}
}
// Il ne manque aucune clef : le POST est bien reçu.
else
{
	// On va utiliser des regex qui vont remplir un array.
	$donnees = array() ;
	// On fait ça là, afin de les afficher plus tard sur la page.
	
	// A chaque valeur invalide, l'array recevra la valeur 'Null'.
	$donnees['nom']		=	preg_match(	'#^[a-z -]{2,}$#i'									, $_POST['nom']			) ? strtoupper($_POST['nom'])		: null;
	$donnees['prenom']	=	preg_match(	'#^[a-z-]{2,}$#i'									, $_POST['prenom']		) ? strtoupper($_POST['prenom'])	: null;
	$donnees['matricule']	=	preg_match(	'#^[0-9]{4,5}$#'									, $_POST['matricule']	) ? $_POST['matricule']				: null;
	$donnees['email']	=	preg_match(	'#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#'		, $_POST['email']		) ? $_POST['email'] 				: null;
	$donnees['telephone']=	preg_match(	'#^(0|\+40)[-. ]?7[0-9]{2}([-. ]?[0-9]{3}){2}$#'	, $_POST['telephone']	) ? $_POST['telephone']				: null;
	$donnees['annee']	=	preg_match(	'#^[3-6]$#'											, $_POST['annee'] 		) ? (int) $_POST['annee'] 			: null;
	
	if (  $_POST['motDePasse'] ==  $_POST['confMotDePasse'] )
	{	$donnees['motDePasse']	=	preg_match(	'#^[a-zA-Z0-9@_-]{6,}$#'	, $_POST['motDePasse']	) ? better_crypt($_POST['motDePasse'])		: null;	}

	// Il peut manquer des valeurs dans $_POST
	if ( contains_null($_POST) )
	{
		$errorType = 3 ;
	}
	// Toutes les valeurs sont là : il faut les filter
	else
	{	
		// Les valeurs filtrées par les regex sont dans $donnees
		// Si l'array $donnees contient des valeurs nulles, il faut demander une correction.
		if ( contains_null($donnees) )
		{
			$errorType = 4 ;
		}
		// Les données sont bonnes, mais le matricule existe déjà.
		elseif ( $em->matriculeExiste($donnees['matricule']) )
		{
			$errorType = 5;
		}
		elseif ( $siteconfig->allowRegister() == 0 )
		{
			$errorType = 6;
		}
		// Sinon, on peut créer l'élève.
		else
		{
			$inscrit = new eleve($donnees) ;
			
			if ($siteconfig->bypassApproval() == 'off')
			{
				envoyerMail($inscrit, 'Inscription réussie', 'inscription_waitconfirm') ;		
				$em->add($inscrit) ;
			
				$id = $em->getId($inscrit->matricule() ) ;
		   		log_add($id, 'Sign-Up', 'Account created - waiting for confirm') ;
			}
			else
			{
				$em->add($inscrit) ;
				$id = $em->getId($inscrit->matricule() ) ;
				$inscrit = $em->get($id);
		   		$em->approve($inscrit);
			
		   		log_add($id, 'Sign-Up', 'Account created and approved without admin') ;
		   		 
				envoyerMail($inscrit, 'Compte approuvé', 'inscription_confirmed') ;
			}
		}
	}
}
