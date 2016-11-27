<?php

classe('o', 'page-header') ;
display('page_config', 'h1' ) ;
classe('c') ;

$f = new form('horizontal') ;

$f->input('websiteTitle',	translate('websiteTitle'), 	null, $siteconfig->websiteTitle() ) ;
$f->input('websiteMoto',	translate('websiteMoto'), 	null, $siteconfig->websiteMoto() ) ;
$f->input('websiteFooter',	translate('websiteFooter'), 	null, $siteconfig->websiteFooter() ) ;
$f->liste('websiteLanguage',	translate('websiteLanguage'), 	array_flip($listelangues), $siteconfig->websiteLanguage() ) ;
$f->radiolist('allowRegister',	translate('allowRegister'), 	array('on' => 'Yes', 'off' => 'No'), $siteconfig->allowRegister() ) ;
$f->radiolist('bypassApproval',	translate('bypassApproval'), 	array('on' => 'Yes', 'off' => 'No'), $siteconfig->bypassApproval() ) ;
$f->radiolist('allowAnamneses',	translate('allowAnamneses'), 	array('on' => 'Yes', 'off' => 'No'), $siteconfig->allowAnamneses() ) ;
$f->number('patientLimit',	translate('patientLimit'), 	$siteconfig->patientLimit() ) ;
/**/
$f->submit( translate('save') );

$f->output() ;
