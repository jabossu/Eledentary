
<!-- ===================================
			Bannière du site : 
==================================== -->
<div id='banniere'>
	<div class='row'>

	<div class="col-sm-7">
		<h3><?php display('site_name') ;?></h3>
		
		<div class='text-left'><h5><b>&rsaquo;</b> <?php display('site_title') ;?></h5></div>
	</div>
	
	<div class="col-sm-3 languages text-right">
	<?php

	foreach( $listelangues as $nom => $code )
	{
		if ( $code == $_SESSION['langue'] )
		{
			$selected = 'current_language' ;
		}
		else
		{
			$selected = '' ;
		}
		
		echo "\t<a href='/?langue=". $code ."' title='Traduire en ". $nom ."'><img src='ressources/images/flag-". $code .".jpg' class='img-thumbnail ". $selected ."' alt='Drapeau ". $nom ."' width='60' /></a>" ;
	}

	?>
	</div>
	
	<div class="col-sm-1">
		<a href="http://eoolh.legtux.org"><img class="logo-icon img-circle img-responsive" alt="Le logo de la CMC dentaire" src='ressources/images/logo.png'></a>
	</div>
	
	</div>
</div>


