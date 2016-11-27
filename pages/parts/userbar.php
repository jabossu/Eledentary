<?php

// ================================
// Data processing
// ================================


$link = function($url, $texte, $glyph=null)
{
	$glyph = ( $glyph != null )		? '<span class="glyphicon glyphicon-'.$glyph.'"></span>'	: null	;
	$active = ( preg_match( "#$url$#" , $_SERVER['QUERY_STRING'] ) ) ? "active" : "inactive" ;
	$chaine = '<li class="' . $active . '"><a href="?page=' . $url . '">' . $glyph . ' ' . translate($texte) ."</a></li>\n" ;
	echo $chaine ;
};

$menu_button	= "";
$menu_content	= "" ;
foreach ( $listelangues as $nom => $code) // $listelangue is an array defined in config.php
{
	if ( $code == $_SESSION['langue'] )
	{
		$menu_button = "<img src='ressources/images/flag-". $code .".jpg' class='img-thumbnail flag' alt='Drapeau ". $nom ."' height='35' /> - " . $nom . "<span class='caret'></span>" ;
	}
	else
	{
		$menu_content .= "<li class='text-justify text-capitalize'><a href='/?langue=". $code ."' title='Traduire en ". $nom ."'><img src='ressources/images/flag-". $code .".jpg' class='' alt='Drapeau ". $nom ."' width='30' /> - ".$nom."</a></li>" ;
	}
}

// -------------------------------

$em = new elevesManager($bdd) ;
$mm = new messagesManager($bdd) ;

$str_eleves="" ;
$n = $em->nombre('nouveau') ;
if ( $n > 0)
{
	$str_eleves .= $n . ' ' ;
	$str_eleves .= translate('new_users') ;
}
else
{
	$str_eleves .= translate('no_new_user') ;
}

// ================================
// Userbar building
// ================================

?>

<nav class="navbar navbar-reverse navbar-fixed-top userbar container-fluid ">
	<div class="navbar-header navbar-element">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse">
		<span class="sr-only">Toggle navigation</span>
		<span class="glyphicon glyphicon-menu-hamburger"></span>
		</button>
		<div class="navbar-brand"  >
			<b>
			<a href="#menu-toggle" id="menu-toggle" data-toggle="tooltip" title="Show / Hide menu"><span class="glyphicon glyphicon-menu-hamburger"></span></a>
			<?php echo $siteconfig->websiteTitle() ; ?>
			</b>
		</div>
	</div>

	<div class="collapse navbar-collapse" id="bs-navbar-collapse">
		
		<ul class="nav navbar-nav navbar-left">
			<?php
	
			if ( isset($_SESSION['profile']) and $_SESSION['profile']->statut() == 'administrateur' )
			{?>
			<ul class="nav navbar-nav navbar-left">
				<li class="notification"><a href="/?page=viewmessages" type="button" data-toggle="tooltip" data-placement="bottom" class="admin-boutton" title="<?php display('admin_messages') ;?>"><span class="glyphicon glyphicon-envelope"></span> <span class="badge"><?php echo $mm->nombre('nonlu') ; ?></span></a></li>
				<?php if( $siteconfig->bypassApproval() == 'off' ) {?>
				<li class="notification"><a href="/?page=eleves&year=0&role=nouveau" type="button" data-toggle="tooltip" data-placement="bottom" class="admin-boutton" title="<?php echo $str_eleves  ;?>"><span class="glyphicon glyphicon-user"></span> <span class="badge"><?php echo $em->nombre('nouveau') ; ?></span></a></li>
				<?php }?>
				<li class="notification"><a href="/logs.php" type="button" data-toggle="tooltip" data-placement="bottom" class="admin-boutton" title="<?php display('go_logs') ;?>"><span class="glyphicon glyphicon-eye-open"></span></a></li>
			</ul>
	
			<?php }	?>
		</ul>
	
		<ul class="nav navbar-nav navbar-right">
			
			<?php
			
			if ( isset($_SESSION) and isset($_SESSION['profile']) )
			{
			
			?>
			
			<li class="dropdown">
				<a data-toggle="dropdown" class="dropdown-toggle" href="#">
					<img alt="" src="ressources/images/profile_icon.png" height='35px'>
					<span class="username"><?php display('hello_message', null , '<b>' . ucwords( strtolower($_SESSION['profile']->prenom() . ' ' . $_SESSION['profile']->nom()), ' -' ) . '</b>' ) ; ?></span>
					<b class="caret"></b>
				</a>
				<ul class="dropdown-menu extended logout">
					<?php
					$link('profile&id=' . $_SESSION['profile']->id(), 'page_profile', 'user');
					?>
					<li><a href='?page=sendmessage'><span class="glyphicon glyphicon-send"></span> <?php display('page_contact') ; ?></a></li>
				
					<li><a href='/?page=accueil&action=logout'><span class="glyphicon glyphicon-off"></span> <b><?php display('page_deconnexion') ; ?></b></a> </li>
				</ul>
			</li>
			
			<?php
			}
			?>
			
			<li class="dropdown">
				<a data-toggle="dropdown" class="dropdown-toggle" href="#">
					<span class="languemenu">
					<?php echo $menu_button ;?>
					</span>
				</a>
	
				<ul class="dropdown-menu extended" aria-labelledby="dropdownMenu">
					<?php echo $menu_content ;?>
				</ul>
			</li>	
			
		</ul>
	</div>
</nav>
