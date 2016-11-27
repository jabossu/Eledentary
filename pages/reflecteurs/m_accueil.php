<?php

$errorType = 0 ;

$am = new articlesManager($bdd) ;

$listeArticles = $am->getNewest() ;
