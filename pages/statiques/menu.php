
<!-- ===================================
				Menu : 
=================================== -->
<div id='menu'>
<?php

$em = new elevesManager($bdd) ;
$pm = new patientsManager($bdd) ;

if ($_SERVER['QUERY_STRING'] == '')
{
	$_SERVER['QUERY_STRING'] = '?page=accueil' ;
}

$link = function($url, $texte, $glyph=null)
{
	$glyph = ( $glyph != null )		? '<span class="glyphicon glyphicon-'.$glyph.'"></span>'	: null	;
	$active = ( preg_match( "#$url$#" , $_SERVER['QUERY_STRING'] ) ) ? "active" : "inactive" ;
	$chaine = '<li class="' . $active . '"><a href="?page=' . $url . '">' . $glyph . ' ' . translate($texte) ."</a></li>\n" ;
	echo $chaine ;
};

?>

	<?php display('menu_title', 'h2') ; ?>
	<ul class="nav nav-pills nav-stacked">
	  	<?php
	  	
	  	// Toujours affichés
		$link('accueil', 'home', 'home') ;
		if ( !isset( $_SESSION['profile'] ) )
		{
			$link('connexion', 'page_connexion', 'log-in') ;
			$link('inscription', 'page_inscription', 'pencil') ;
		}
		else
		{
			$link('profile&id=' . $_SESSION['profile']->id(), 'page_profile', 'user');
			$link('dentchat', 'page_dentchat', 'comment');
		
	  	
	  	?>
	  	
		<script>
			document.write('<div class="dropdown nav nav-pills nav-stacked">') ;
			document.write('<li class="dropdown-toggle" id="PatientMenu" data-toggle="dropdown"><a href="#"><span class="glyphicon glyphicon-hdd"></span> <?php display('patient_managing') ;?> <span class="glyphicon glyphicon-menu-down"></span></a></li>');
			document.write('<ul class="dropdown-menu dropdown-menu-right">');
		</script>
			
		<noscript>
			<div>
			<ul class="nav nav-pills nav-stacked">
		</noscript>
	  	
	  	<?php
			$link('patients', 'page_patients', 'list-alt');
			$link('profile_patient', 'create_patient', 'edit');
			if ( ! $em->isFree($_SESSION['profile'] ) )
			{	$link('profile_patient&id=' . $em->findPatient($_SESSION['profile']) , 'my_patient', 'user');	}
			//$link('dentissimo', 'page_dentissimo', 'book');
		?></ul>
		</div>
	  	
	  	<?php
	  	
	  	}
	  	
	  	if ( isset( $_SESSION['profile'] ) and $_SESSION['profile']->statut() == 'administrateur' )
		{	?>
			<script>
				document.write('<div class="dropdown nav nav-pills nav-stacked">') ;
				document.write('<li class="dropdown-toggle" id="AdminiMenu" data-toggle="dropdown"><a href="#"><span class="glyphicon glyphicon-dashboard"></span> <?php display('administration') ;?> <span class="glyphicon glyphicon-menu-down"></span></a></li>');
				document.write('<ul class="dropdown-menu dropdown-menu-right">');
			</script>
			
			<noscript>
				<div>
				<ul class="nav nav-pills nav-stacked">
			</noscript>
	
			<?php
				$link('eleves', 'page_eleves', 'education');
				$link('pathologie_liste', 'page_liste_patho', 'list-alt');
				$link('pathologie_add', 'page_add_pathologies', 'plus-sign');
				$link('news', 'page_news', 'text-background');
			?></ul>
			</div>
			
	  	<?php	}  	?>
	  	
	  	<script>
			document.write('<div class="dropdown nav nav-pills nav-stacked">') ;
			document.write('<li class="dropdown-toggle" id="AboutMenu" data-toggle="dropdown"><a href="#"><span class="glyphicon glyphicon-info-sign"></span> <?php display('about') ;?> <span class="glyphicon glyphicon-menu-down"></span></a></li>');
			document.write('<ul class="dropdown-menu dropdown-menu-right">');
		</script>
		
		<noscript>
			<ul class="nav nav-pills nav-stacked">
		</noscript>
		
		<?php
			$link('contact_us', 'page_about_us', 'sunglasses');
			$link('bbcode', 'page_howto_bbcode', 'text-size');
		?></ul></div>
	  	<li class="list-group-item"><?php display('nb_patients', 'b') ?><span class="badge"><?php echo '<b>' . $pm->compter() . '</b>' ; ?></span></li>
	  	<li class="list-group-item"><?php display('nb_inscrits', 'b')?><span class="badge"><?php echo '<b>' . $em->nombre() . '</b>' ; ?></span></li>
	  	
	  	<?php if ( isset( $_SESSION['profile'] ) and $_SESSION['profile']->statut() == 'administrateur' )
		{	?><a href="/logs.php" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-eye-open"></span> <?php display('go_logs') ; ?></a> <?php } ?>
	  	 
	</ul>
</div>

<?php	unset( $link ) ;
