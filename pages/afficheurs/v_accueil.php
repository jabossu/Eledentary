<?php

//********************************
function glyph($glyphname, $style=null)
{
    $s = ( $style != null ) ? ' style="'.$style.' ;"' : '';
    echo "<span class='glyphicon " . $glyphname . "' ".$s." aria-hidden='true'></span>" ;
}

if ($successDeco == true)
{	alerte('loged_out', success);	}


classe('o', 'page-header') ;
display('home', 'h1' ) ;
classe('c') ;

// Première ligne ===================================================================
classe('o', 'row');
	//----------------------------------------------------------------------------
	classe('o', 'col-md-5 well well-tile');
		classe('o', 'col-md-2');
			glyph("glyphicon-user", "font-size: 6em");
		classe('c');
		
		classe('o', 'col-md-8');
			display("connected_as", "b");
			echo '<ul class="list-group">';
			echo '<li class="list-group-item"><b><em>' . $_SESSION['profile']->prenom() . ' ' . $_SESSION['profile']->nom() . '</em></b></li>';
			echo '<li class="list-group-item"><b>' . translate('annee') . ' :</b> ' . '<span class="badge"><b>' . $_SESSION['profile']->annee()  . '</b></span>' . '</li>';
			echo '<li class="list-group-item"><b>' . translate('email') . ' :</b> <span class="badge"><b>' . $_SESSION['profile']->email() . '</b></span></li>';
			echo '<ul>';
		classe('c');
	classe('c');
	//----------------------------------------------------------------------------
	classe('o', 'col-md-5  well well-tile');
		classe('o', 'col-md-2');
			glyph("glyphicon-flag", "font-size: 6em");
		classe('c');
		
		classe('o', 'col-md-8 col-md-offset-1');
			display("my_stats", "b");
			echo '<ul class="list-group">';
			echo '<li class="list-group-item">' . translate('nombre_soins') . ' : <span class="badge"><b>' . $_SESSION['profile']->soins() . '</b></span></li>';
			echo '<li class="list-group-item">' . 'Mes de patients' . '<span class="badge"><b>' . $myPatients . '</b></span>' . '</li>';
			echo '<li class="list-group-item">' . 'Statut' . '<span class="badge"><b>' . $_SESSION['profile']->statut() . '</b></span></li>';
			echo '<ul>';
		classe('c');
	classe('c');
	//----------------------------------------------------------------------------
classe('c');

// Deuxième ligne ===================================================================
classe('o', 'row');
	//----------------------------------------------------------------------------
	classe('o', 'col-md-2 well well-tile');
		
		echo '<ul class="list-group">';
		echo '<li class="list-group-item">' . 'Nombre d\'utilisateurs' . '<span class="badge"><b>' . $n_e . '</b></span>' .'</li>';
		echo '<li class="list-group-item">' . 'Limite de patients' . '<span class="badge"><b>' . $siteconfig->patientLimit() . '</b></span>' . '</li>';
		echo '<li class="list-group-item">' . 'Nombre d\'administrateurs' . '<span class="badge"><b>' . $n_eadmin . '</b></span>' . '</li>';
		echo '<ul>';
		
	classe('c');
	//----------------------------------------------------------------------------
	classe('o', 'col-md-8 well well-tile');
		
		classe('o', 'col-md-10 col-md-push-1');
?>		<div class="progress">
			<div class="progress-bar progress-bar-warning progress-bar-striped progress-bar-left" style="min-width: 2em; width: <?php echo $f_pr ;?>%">
				<span class="sr-only"><?php echo $f_pr ;?>% Complete</span>
			</div>
			<div class="progress-bar progress-bar-striped" style="min-width: 2em; width: <?php echo $f_pf ;?>%">
				<span class="sr-only"><?php echo $f_pf ;?>% Complete</span>
			</div>
			<div class="progress-bar progress-bar-success  progress-bar-striped progress-bar-right" style="min-width: 2em; width: <?php echo $f_e ;?>%">
				<span class="sr-only"><?php echo $f_e ;?>% Complete</span>
			</div>
		</div><?php
		classe('c');
		
		
		classe('o', 'col-md-10 col-md-offset-1');
			echo '<br><ul class="list-group">';
			echo '<li class="list-group-item">' . 'Nombre de patients réservés' . '<span class="badge"><b>' . $n_pr . '</b></span>' .'</li>';
			echo '<li class="list-group-item">' . 'Nombre de patients libres' . '<span class="badge"><b>' . $n_pf . '</b></span>' . '</li>';
			echo '<li class="list-group-item">' . 'Nombre d\'étudiants' . '<span class="badge"><b>' . $n_e . '</b></span>' . '</li>';
			echo '<ul>';
		classe('c');
		
	classe('c');
	//----------------------------------------------------------------------------
classe('c');
/*
foreach ($listeArticles as $a)
{
	?>
	<div class="row">
		<p class="text-left slime-text"><a href='#' class="btn-sm btn-primary"><?php echo $a->date('fr_FR') ;?></a></p>
		<div class='col-sm-6'>
		<h3><?php echo $a->titre('fr_FR') ; ?> 
		<?php
		if ( isset( $_SESSION['profile'] ) AND $_SESSION['profile']->statut() == 'administrateur' )
			{?><small><a href="?page=news&action=edit&id=<?php echo $a->id() ; ?>" class="btn btn-link">Éditer</a></small><?php }
		?></h3>
		<p class="news"><?php echo bbdecode($a->contenu('fr_FR')) ; ?></p>
		</div>
		<div class='col-sm-6'>
		<h3><?php echo $a->titre('en_EN') ; ?> 
		<?php
		if ( isset( $_SESSION['profile'] ) AND $_SESSION['profile']->statut() == 'administrateur' )
			{?><small><a href="?page=news&action=edit&id=<?php echo $a->id() ; ?>" class="btn btn-link">Edit</a></small><?php }
		?></h3>
		<p class="news"><?php echo bbdecode($a->contenu('en_EN')) ; ?></p>
		</div>
	</div>
	<?php
}
?>
<br />
<a class="btn btn-default btn-block" href="/?page=allnews"><b><i><?php display('read_all') ;?></i></b> <span class="glyphicon glyphicon-share-alt"></span></a>
*/
