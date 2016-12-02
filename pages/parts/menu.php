<div class="affix sidebar-nav">
<?php

$em = new elevesManager($bdd) ;
$pm = new patientsManager($bdd) ;


$link = function($url, $texte, $glyph=null)
{
	$glyph = ( $glyph != null )		? '<span class="glyphicon glyphicon-'.$glyph.'"></span>'	: null	;
	$active = ( preg_match( "#=$url$#" , $_SERVER['QUERY_STRING'] ) ) ? 'class="active"' : null ;
	$chaine = "\t<li ". $active . '><a class="nav-menu" href="?page=' . $url . '">' . $glyph . ' ' . translate($texte) ."</a></li>\n" ;
	echo $chaine ;
};

?>

<ul class="nav nav-pills nav-stacked">
<?php
	$link('accueil', 'home', 'home') ;
	if ( !isset( $_SESSION['profile'] ) )
	{
		$link('connexion', 'page_connexion', 'log-in') ;
		$link('inscription', 'page_inscription', 'pencil') ;
	}
	else
	{
		$link('dentchat', 'page_dentchat', 'comment');
		$link('patients', 'page_patients', 'list-alt');
		$link('profile_patient', 'create_patient', 'edit');
		$link('my_patients' , 'my_patient', 'user');
		//$link('dentissimo', 'page_dentissimo', 'book');
	}
	
	if ( isset( $_SESSION['profile'] ) and $_SESSION['profile']->statut() == 'administrateur' )
	{
		//echo "<li class='nav-menu nav-header'><a class='nav-menu'>" . translate('administration') . "</a></li>" ;
		$link('eleves', 'page_eleves', 'education');
		$link('pathologie_liste', 'page_liste_patho', 'list-alt');
		$link('pathologie_add', 'page_add_pathologies', 'plus-sign');
		$link('news', 'page_news', 'text-background');
		$link('config', 'page_config', 'cog');
		$link('traduction', 'page_translation', 'transfer');
	}
	
	//echo "<li class='nav-header'><a class='nav-menu'>" . translate('divers') . "</a></li>" ;
	$link('contact_us', 'page_about_us', 'sunglasses');
	$link('bbcode', 'page_howto_bbcode', 'text-size');
	?>
</ul>
<?php
unset( $link ) ;

?>
</div>
