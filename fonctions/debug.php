<?php

function show($var)
{
	echo '<pre><h3>Var Type:</h3>' ;
	echo gettype($var);
	echo '<h3>Var content:</h3>';
	print_r( $var );
	echo '<hr/>';
	echo '<h3>Var value:</h3>';
	echo $var ;
	echo '<hr/>';
	echo '<h3>Var boolean:</h3>';
	echo ($var == true) ? 'true' : 'false' ;
	echo '</pre>' ;
}
