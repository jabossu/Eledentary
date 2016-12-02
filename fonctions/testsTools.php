<?php

function contains_null(array $tableau)
// Test si le tableau contient des clefs sans valeaurs associées
// Renvoie ces clefs si oui
// Renvoie False sinon
{
	$clefs_vides = array() ;
	foreach ($tableau as $k => $v)
	{
		if ( $v == '' )
		// Vraie si la valeur est NULL ou vide
		{
			$clefs_vides[] = $k ;
		}
	}
	if ( count($clefs_vides) > 0)
	{		return $clefs_vides ;	}
	else
	{		return false ;	}
}

function missing_keys( array $tableau, array $clefs )
// Vérifie que chaque clef de l'arrau $clefs existe dans l'array $tableau
// Renvoie les clefs qui n'esistent pas
// Renvoie False si elles sont toutes présentes.
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
