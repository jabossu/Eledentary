<?php

classe('o', 'page-header') ;
display('Dentissimo', 'h1' ) ;
classe('c') ;

?>
		<h3><?php echo $d->titre('fr_FR') ; ?> </h3>
		<p><?php echo bbdecode($d->contenu('fr_FR')) ; ?></p>

