<h1>Hello world</h1>
<?php

$sm = new siteconfigManager($bdd) ;
$a = new siteconfig( array() );
$b = new siteconfig( array() );

$c = $sm->get() ;

$c->setWebsiteTitle('Test') ;
$c->setWebsiteMoto('the cake is a lie') ;	
$c->setWebsiteFooter('for the glory!'); 
$c->setWebsiteLanguage('fr_FR'); 
$c->setAllowRegister(true) ;
$c->setBypassApproval(false) ;
$c->setAllowAnamneses(true) ;
$c->setPatientLimit(4) ;


$sm->update($c);

$c = $sm->get() ;

echo '<pre>'; print_r($c); echo '</pre>';

echo 'done';
