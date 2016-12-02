<?php

function display($clef, $style='', $var='')
{
	echo translate($clef, $style, $var) ;
}
function comment($text)
{
	echo "\n<!-- =====================\n" ;
	echo "\t\t" . $text . "\n";
	echo "====================== -->\n" ;
}

function loadTraduction($lang)
// fetch the language file and build the array $traduction from it
{
	$t = array() ;
	
	$handle = fopen('langues/'.$lang.'.csv', 'r');
	if ($handle)
	{
		while (($line = fgetcsv($handle, 1000, ";" )) !== false) {
			$t[ $line[0] ] = $line[1];
		}
		fclose($handle);
	} else {
		// error opening the file.
		exit("Critical error : language ".$lang." doesnt exist");
	} 
	
	return $t ;
}

function translate($clef, $style='', $var='')
{
	global $traduction ;
	
	if ( isset( $traduction[$clef] ) )
	{
		$chaine = $traduction[$clef];
		$regex = "#^(.*)%(.*)%(.*)$#" ;
		if ($var == '')
		{	$var = 'MISSING_$2' ;	}
		$remplacement = '$1' . $var . '$3' ;

		$chaine = preg_replace($regex, $remplacement, $chaine) ;
	}
	else
	{
		$chaine = '[ ' . strtoupper($clef) . ' ]' ;
	}
		
	
	switch ($style)
	{
		case 'p':
			$code='p' ;
		break;
		case 'b':
			$code='b' ;
		break;
		case 'i':
			$code='i';
		break;
		case 'u':
			$code='u';
		break;
		case 'strong':
			$code='strong';
		break;
		case 'h1':
			$code='h1';
		break;
		case 'h2':
			$code='h2';
		break;
		case 'h3':
			$code='h3';
		break;
		case 'h4':
			$code='h4';
		break;
		case 'h5':
			$code='h5';
		break;
		
		
				
		default:
			$code='none' ;
		break;
	}
	
	if ($code != 'none')
	{
		$chaine = '<' . $code . '>' . $chaine . '</' . $code . '>' ;
	}
	
	return $chaine ;
}

function classe($a, $c='')
{
	if ( $a == 'o')
	{
		echo '<div class="' . $c . '">';
	}
	else
	{
		echo '</div>' ;
	}
	
}

function in_div($classe, $content)
{
	classe('o', $classe);
	echo $content;
	classe('c') ;
}


function alerte($clef, $style='success', $var='', $translate=true)
{
	$chaine = ($translate) ? translate($clef, '', $var) : $clef ;
	echo '<div class="alert alert-' . $style . ' fade in">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.
	$chaine .
	'</div>' ;
}

function remplacer($texte)
{
	return $texte ;
}
