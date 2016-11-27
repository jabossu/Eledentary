<?php

if ($successDeco == true)
{	alerte('loged_out', success);	}


classe('o', 'page-header') ;
display('home', 'h1' ) ;
classe('c') ;

classe('o', 'news') ;
display('home_msg', 'p') ;
classe('c') ;


classe('o', 'page-header text-right') ;
display('last_news', 'h3' ) ;
classe('c') ;

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

