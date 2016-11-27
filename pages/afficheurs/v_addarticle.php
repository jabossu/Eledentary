<?php


classe('o', 'page-header') ;
display('page_news', 'h1' ) ;
classe('c') ;
switch ($errorType)
{
	case 0:		alerte('news_msg_success') ;	break;
	case 4:		alerte('delete_msg_success') ;	break;
	case 1:		alerte('news_msg_new', 'info') ;	break;
	case 2:		alerte('news_msg_error', 'danger') ;	break;
	case 3:
		foreach (contains_null($_POST) as $key => $value)
		{
			alerte('news_missing_infos', 'warning', translate($value)) ;
		}
	break;
}

echo "\n" ;	

if ($mode == 'edit')
{ ?>
	<div class="well container-fluid col-sm-10 col-sm-push-1">
	<div class="col-sm-3 col-sm-push-3">
		<a href="?page=accueil" class="btn btn-primary"><?php display('home') ;?></a>
	</div>
	<div class="col-sm-3 col-sm-push-4">
		<a href="?page=news&action=delete&id=<?php echo $donnee['id'] ;?>" class="btn btn-warning"><?php display('delete_post') ;?></a>
	</div></div>
<?php }

$form = new form('classic', 'write_post' ) ;

$form->input('fr_titre', translate('fr_titre'), 'text', $donnee['fr_titre'], null, 'FR' ) ;
$form->textarea('fr_contenu', translate('fr_contenu'), $donnee['fr_contenu'], 'Ecrivez votre article', 15) ;
$form->input('en_titre', translate('en_titre'), 'text', $donnee['en_titre'], null, 'EN' ) ;
$form->textarea('en_contenu', translate('en_contenu'), $donnee['en_contenu'], 'Write your post', 15) ;
$form->submit( translate('publish_post') );

$form->output() ;
