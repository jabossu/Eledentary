<?php


// ============= Donnees et Appels ===========
include("config.php") ; // contient les parametres de base du site, comme ceux de la base de donnee, ou encore son nom
include("init.php") ;	// contient les fonctions à appeller avant tout les reste, notamment la $bbd et les sessions.
$lm = new logManager($bdd) ;

// ============= Ajout des parties de pages ===========
// Ajoute tout le contenu des balises <head>
include("pages/statiques/header.php") ;
// Le body, avec un container fixe de bootstrap
echo '<body class="container" >';
// La belle bannière...
echo '<div class="row">' ;
	classe('o', "col-sm-12");
	include("pages/statiques/banner.php") ;
	classe('c') ;
echo '</div>';
echo "\n";

if ( !isset($_SESSION['profile']) or $_SESSION['profile']->isAdmin() == false )
{
	classe('o', 'row') ;
	classe('o', "col-sm-12 col-md-12");
	echo '<div id="corps">' ;
	include($WEBPAGE['403']) ;
	echo '</div>' ;
	classe('c') ;
	classe('c') ;
}
else
{

classe('o', "row") ;

    $monthList = array(
		'01' =>	'January',
		'02' =>	'February',
		'03' =>	'March',
		'04' =>	'April',
		'05' =>	'May',
		'06' =>	'June',
		'07' =>	'July',
		'08' =>	'August',
		'09' =>	'September',
		'10' =>	'October',
		'11' =>	'November',
		'12' =>	'December') ;
        
    $days = array();
    foreach( range(1, 31) as $v )
    {
        $days[$v] = $v ;
    }


	classe('o', "col-sm-12 col-md-12");
		echo '<div id=corps>';
		
		classe('o', 'text-center');
			echo '<a href="/" id="top" class="btn btn-primary">Back to website</a>' ;
			echo '<a href="/logs.php" id="top" class="btn btn-primary">Reset filters</a>' ;
		classe('c') ;
		
		classe('o', 'row') ;
			$_POST['year'] = ( isset($_POST['year']) ) ? $_POST['year'] : date('Y') ;
			$_POST['month'] = ( isset($_POST['month']) ) ? $_POST['month'] : date('n') ;
			//$_POST['day'] = ( isset($_POST['day']) ) ? $_POST['day'] : date('d') ;
			
			echo '<h3>&nbsp;&nbsp;&nbsp;&nbsp;Select a Date : </h3>' ;
			classe('o', 'well text-center') ;
			$f = new form('inline') ;
				for ($i = $lm->getOldestYear() ; $i <= date("Y"); $i++) {
				    $y[$i] = $i;
				}
			$f->liste( 'year', null, $y, $_POST['year'] ) ;
			$f->liste( 'month', null, $monthList, $_POST['month'] ) ;
    		$f->liste( 'day', null, $days, $_POST['day'] ) ;
			$f->submit('Filter', 'warning') ;
			$f->output() ;
			classe('c') ;
		classe('c') ;
		
		echo '<pre>' ;
		
		$vA = array('year', 'month', 'day') ;
		if ( missing_keys($_POST, $vA) AND missing_keys( $_POST, $vA) != $VA OR ( contains_null($_POST) ) )
		{
			$liste = $lm->getAll() ;
		}
		else
		{
			$dmonth = intval ( $_POST['month'] ) ;
			$year = intval ( $_POST['year'] ) ;
            $day = intval ( $_POST['day'] ) ;
			$emonth = ( $dmonth + 1 ) % 12;
			if ($emonth == 1)
			{
				$eyear = $year + 1 ;
			}
			else
			{
				$eyear = $year ;
			}			

			if ($emonth == 0)
			{
				$emonth = 12 ;
			}
			elseif ($emonth < 10)
			{
				$emonth = '0' . $emonth ;
			}
            
            if ( checkdate( intval($dmonth), intval($day), intval( $year ) ) == false  )
            {
                $day = 1 ;
            }
			
			$debut = $year . '-'. $_POST['month'] . '-' . $day . ' 00:00:00' ;
			$fin = "$eyear-$emonth-01 02:00:00" ;
			
			$liste = $lm->getMonthly( $debut, $fin ) ;
		}
        
        echo '<table class="log">' . "\n" ;
        ?>
        <theader>
            <th style="width : 17% ;" >Time</th>
            <th style="width : 13% ;" >User Ip adress</th>
            <th style="width : 20% ;" >User Name<br/><small>(click to access profile)</small></th>
            <th style="width : 50% ;" >Event</th>
        </theader>
        <?php
        $s = '</td><td>' ;
		foreach ($liste as $l)
		{
			$line = '<tr><td>' ;
            $line .= $l->date() . $s ;
            $line .= $l->ipaddress() . $s ;
            $line .= '<a href="/?page=profile&id=' . $l->iduser() . '">' . $l->nuser() . ' ' . $l->puser() . '</a>' . $s ;
            $line .= '<b>' . $l->action() . '</b> : ' . $l->details() ;
            $line .= '</td></tr>' ;
            
			echo $line . "\n" ;
		}
		echo '</table>' ;
		echo '</pre>' ;
		
	classe('o', 'text-center');
			echo '<a href="#top" class="btn btn-block btn-primary">Back to top</a>' ;
	classe('c') ;
	classe('c') ;
}


	classe('o', "col-sm-12");
		include("pages/statiques/footer.php");
	classe('c') ;
classe('c') ;
echo '</body>' ;
