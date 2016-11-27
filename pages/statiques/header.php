<!DOCTYPE html>
<html lang="<?php echo $_SESSION['langue'] ; ?>">

<head>
	
	<!-- CSS ressources -->
	<link rel="stylesheet" href="/ressources/css/yeti.min.css" title='default'>
	<link rel="stylesheet" href="/ressources/principaux.css"> 
	<link rel="stylesheet" href="/ressources/details.css">
	<link rel="stylesheet" href="/ressources/elements.css">
	
	<link rel="shortcut icon" href="/ressources/favicon.ico" type="image/x-icon" />
	
	<!-- Bootstrap ressources -->
	<script src="/ressources/js/jquery-2.1.4.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script src="/ressources/js/custom.js"></script>
	
	

	<!-- Metas Infos ressources -->
	<meta name="keywords" content="CMC, dentaire">
	<meta name="description" content="<?php echo $config['SITE_MOTO'] ;?>">
	<meta charset="UTF-8">
	<meta name="author" content="A. Touati, J-A. Bossu">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	
	<title><?php echo $config['SITE_TITLE'] ; ?></title>

<?php

echo '<!--' ;

include('README.txt') ;

echo '-->' . "\n" ;
?>

</head>
