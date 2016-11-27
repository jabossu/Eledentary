<?php

classe('o', 'page-header text-center') ;
display('last_news', 'h1' ) ;
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
<a class="btn btn-info btn-block" href='#top'><span class="glyphicon glyphicon-arrow-up"></span> <?php display('back_to_top') ;?> <span class="glyphicon glyphicon-arrow-up"></span></a>


