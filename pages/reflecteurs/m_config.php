<?php
$c = new siteconfig( array() );
$cm = new siteconfigManager( $bdd ) ;

$old = $cm->get() ;
$new = new siteconfig( $_POST );

//show( $cm->merge( $old, $new ) ) ;

$siteconfig = $cm->merge( $old, $new );
$cm->update( $siteconfig );
$siteconfig = $cm->get();



