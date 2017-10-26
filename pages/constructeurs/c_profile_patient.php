<?php

$accesslevel = 50;
/*
*	admins 		= 40
*	legitimate	= 35
*	connected	= 30
*	everyone	= 20
*	visitors	= 10
*/
clean($_GET);
$pm = new patientsManager($bdd);


if ( isset( $_GET['id'] ) == false )
# No patient has been required 
# The page is loaded to create a new patient
{
	# then it's either new or an error.
	# Everyone has access to such a page
	$accesslevel =  30 ;
}
elseif ( $pm->existe($_GET['id']) == false )
# No patient match the id looked up
# Everyone can access the page for it will be empty
{
	$accesslevel = 30 ;
}
else 
# A patient is being looked up and he does exist
# We need more datas to know how to handle this
{
	$p = $pm->get($_GET['id']);
	
	if ( $pm->isFree( $p ) )
	# The patient is not reserved
	# Anyone has access
	{
		$accesslevel = 30;
	}
	else
	# The patient is reserved
	# Only it's healer and admins should access the profile
	{
		if ( $_SESSION['profile']->id() == $p->soignant() )
		# The healer ID matches with the user ID
		{ $accesslevel = 30 ; }
		else 
		# The user is different, only admins should be allowed
		{ $accesslevel = 40; }
	}
}
