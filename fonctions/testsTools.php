<?php

function contains_null(array $tableau)
{
	$clefs_vides = array() ;
	foreach ($tableau as $k => $v)
	{
		if ( $v == '' )
		{
			$clefs_vides[] = $k ;
		}
	}
	if ( count($clefs_vides) > 0)
	{
		return $clefs_vides ;
	}
	else
	{
		return false ;
	}
}

function missing_keys( array $tableau, array $clefs )
{
	$clefs_manquantes = array() ;
	foreach ($clefs as $value)
	{
		if ( !array_key_exists( $value , $tableau ) )
		{
			$clefs_manquantes[] = $value ;
		}
	}
	if ( count($clefs_manquantes) == 0)
	{
		return false ;
	}
	else
	{
		return $clefs_manquantes ;
	}
}
