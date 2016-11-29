<?php
$cm = new siteconfigManager( $bdd ) ;

$old = $cm->get() ; 
$new = new siteconfig( $_POST );

$siteconfig = $cm->merge( $old, $new );
$cm->update( $siteconfig );



