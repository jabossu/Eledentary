<?php

$errorType = 0 ;

$pm = new pathologiesManager($bdd) ;

$liste = $pm->liste() ;
