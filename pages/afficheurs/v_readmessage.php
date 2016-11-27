<?php

// ====================================
$button = function ($lien, $texte, $type, $activable=true, $othertab=false)
{
	$a = ($activable == false)	? 'disabled' : '' ;
	$o = ($othertab == true)	? ' target="_blank" ' : '' ;
	echo '<br /><a href="' . $lien . '" class="btn btn-block btn-' . $type . ' ' . $a . '"' . $o . '>' . translate($texte) . "</a>\n";
};

// ==================================== 

classe('o', 'page-header') ;
/*
display('page_readmessage', 'h1');
display('page_rm_msg', 'h4');
*/
classe('c') ;


classe('o', 'col-sm-8');
	
	classe('o', 'page-header') ;
	echo '<h4><b>' . $m->objet() . '</b><br><small>' . $m->date() . '</small>' . '</h4>' ;
	classe('c') ;
	
	classe('o', 'text-right') ;
	echo '<p>' . translate('msg_send_by') . '<strong>' .
		'<a target="_blank" href="?page=profile&id=' . $m->expediteur() . '">' .
		$m->nom() . ' ' . $m->prenom() .
		'</a>' .
		'</strong> [ #<b>' . $m->expediteur() . '</b> ]' . '</p>' ;
	classe('c') ;
	
	classe('o', 'well') ;
	echo bbdecode( $m->corps() ) ;
	classe('c') ;
	
classe('c') ;

classe('o', 'col-sm-4');

	$button('?page=readmessage&action=markread&id=' . $id , 'action_msg_markread', 'primary', ($m->etat() == 'lu') ? false : true );
	$button('?page=readmessage&action=markunread&id=' . $id , 'action_msg_markunread', 'primary', ($m->etat() == 'nonlu') ? false : true );
	echo '<br/>' ;
	$button('mailto:' . $m->email(), 'action_email', 'success', true, true);
	$button('?page=viewmessages', 'page_viewmessages', 'primary');
	$button('/logs.php', 'go_logs', 'warning' );
	
classe('c') ;

unset( $button ) ;
