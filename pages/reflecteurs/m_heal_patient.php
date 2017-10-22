<?php


$errorType = 0 ;
/*
*	1 : Incorrect form
*	2 : Missing infos
*	3 : patient already has a medic
*	4 : Medic already has a patient
*	5 : patient cannot be freed
*/

clean($_POST) ;
clean($_GET) ;

$parametresAttendus = array ( 'motDePasse' ) ;

/**	PROCÉDURE DE LA PAGE
*	
	0 - Charger le patient
	  - Vérifier que le soignant y a accès
	1 - Si le soin est confirmé
	  - Vérifier le mot de passe du soignant
	  - guérir le patient
	  - Modifier la page en conséquence
	2 - Sinon : charger le profile du patient
	  - Afficher une alerte
	  - demander le mot de passe
*
**/

// ==================================================
//	0.a : CHARGER LE PATIENT
// ==================================================
$pm = new patientsManager($bdd) ;
$p = new patient( array() ) ;

if ( isset( $_GET['id'] ) and $pm->existe($_GET['id']) )
{
	$p = $pm->get($_GET['id']);
}
else
{
	exit("Le patient n'existe pas");
}

// ==================================================
//	0.b : VÉRIFICATION DU DROIT D'ACCÈS
// ==================================================
if ($e->id =! $p->soignant() and $e->statut() == 'administrateur')
{
    exit("Accès refusé") ;
}

// ==================================================
//	1.a : soin confirmé
// ==================================================
if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
{
//	Vérifier le mot de passe du soignant
	if ( ! missing_keys( $_POST, $parametresAttendus ) ) # Le motDePasse a bien été reçu
	{
		if ( my_decrypt( $_POST['motDePasse'], $_SESSION['profile']->motDePasse() ) ) # mot de passe correct
		{
		 	//	Guérir le patient
		 	$pm->heal($p);
		 	$mode = "confirmed";
		 	$successType = 1 ;
		 	log_add($_SESSION['profile']->id(), 'Patient healed', $_SESSION['profile']->nom() . ' ' . $_SESSION['profile']->prenom() . ' has cured patient #' . $p->id() );
		}
		else # Mot de passe incorecte
		{
			$errorType = 2 ;
		}
	}
	else # Formulaire
	{
		// Redemander le mot de passe
		$errorType = 1 ;
		$mode = "ultimatum" ;
	}

}
else
{
	$mode = "ultimatum";
}
