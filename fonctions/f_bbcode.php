<?php

function isAssoc($arr)
{
    return array_keys($arr) !== range(0, count($arr) - 1);
}

function array_get(array &$a, $index)
{

	if ( array_key_exists( $index, $a ) == false )
	{
		return false ;
	}
	else
	{
		// Saving the value to return it later
		$value = $a[$index] ;
		
		// If array is associative, we need to find the $index
		if ( isAssoc($a) )
		{
			// Finding the index of the key for associatif tables.
			$n = -1 ;
			foreach ($a as $k => $v)
			{
				$n ++ ;
				if ($k == $index)
				{
					$index = $m ;
				}
			}
			
		}
		// Else : the index is already a number.
			
		// cut the variable out of the array
		array_splice( $a, $index, 1 ) ;
		return $value ;
	}
	
}

function is_bbcode( $str )
{
	$r1 = "#\[[a-z0-9]{1,2}\]#i" ;
	$r2 = "#\[/[a-z0-9]{1,2}\]#i" ;
	
	if ( preg_match($r1, $str) )
	{
		return 'opening' ;
	}
	elseif ( preg_match($r2, $str) )
	{
		return 'closing' ;
	}
	else
	{
		return false ;
	}
}

function smileysdecode($texte)
{
	$smileys = $GLOBALS['smileys'] ;
	foreach ($smileys as $k => $v)
	{
		$texte = preg_replace( '#' . $k .'#', '<img src="/ressources/simple_smileys_1.7/' . $v . '.png" alt="' . $k . '" >', $texte) ;
	}
	return $texte ;
}


function bbdecode($texte)
{
	$bbcode = $GLOBALS['bbcode'] ;

	$r0 = "#(\[/?[a-z0-9]{1,2}\])#i" ;
	$texte = preg_split( $r0, $texte, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE ) ;
	
	$memory = array('init') ;
	$html = '' ;
	
	foreach ($texte as $str)
	{
		$type = is_bbcode($str) ;
		
		if ( $type == 'opening' )
		{
			$memory[] = $str ;
			$html .= $bbcode[$str] ;
		}
		elseif ( $type == 'closing' )
		{
			$b = str_replace('/', '', $str) ;
			$n = array_search( $b , $memory) ;
			if ( $n != false )
			{
				array_get( $memory, $n ) ;
				$html .= $bbcode[$str] ;
			}
		}
		else
		{
			$html .= $str ;
		}
	}
	
	$html = smileysdecode($html) ;
	
	foreach ( array_reverse($memory) as $str)
	{
		$str = str_replace('[', '[/', $str) ;
		$html .= $bbcode[$str] ;
	}
	$html = str_replace("\n", "<br>\n", $html) ;
	
	return $html ;
}
