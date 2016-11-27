<?php

classe('o', 'page-header') ;
display('page_add_pathologies', 'h1') ;
classe('c') ;

switch ($successType)
{
	case 1:
		alerte('patho_added');
		break;
	
	case 2:
		alerte('patho_edited');
		break;
	
	case 3:
		alerte('patho_deleted');
		break;
}
switch ($errorType)
{
	case '1':
		alerte('patho_invalid', 'warning');
		break;
}

classe('o', 'row') ;
	
	classe('o', 'col-sm-9');
	$f = new form('classic', translate('create_pathologie') ) ;
	$f->input('nom_fr_FR', translate('nom_patho_fr'), 'text', $p->nom('fr_FR'), 'ex: carrie', 'Fr') ;
	$f->input('nom_en_EN', translate('nom_patho_fr'), 'text', $p->nom('en_EN'), 'ex: carrie', 'En') ;
	$f->input('details_fr_FR', translate('details_patho_fr'), 'text', $p->details('fr_FR'), 'Nota bene', 'Fr' ) ;
	$f->input('details_en_EN', translate('details_patho_en'), 'text', $p->details('en_EN'), 'Nota bene', 'En' ) ;
	$choix = array();
		foreach (range(3,6) as $v)
		{		$choix[$v] = translate($v) ;	}
	$f->checkbox('annees', translate('annees_soignantes'),  $choix, $p->p_annees()) ;
	$f->submit(translate('save')) ;
	$f->output() ;
	classe('c');
	
	classe('o', 'col-sm-3');
	echo '<br /><a href="/?page=pathologie_add&id='. $p->id() .'&action=delete" class="btn btn-block btn-danger">' . translate('patho_suppr') . "</a>\n";
	echo '<br /><a href="/?page=pathologie_liste" class="btn btn-block btn-success">' . translate('page_liste_patho') . "</a>\n";
	classe('c');

classe('c') ;
