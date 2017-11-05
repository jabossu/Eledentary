<?php

if ( ( isset( $_GET['page'] ) and $_GET['page'] ==  'accueil' ) and ! ( isset( $_SESSION['profile'] ) ) )
{
	header('Location: /');      
}
elseif ( !( isset( $_GET['page'] ) ) and isset( $_SESSION['profile'] ) )
{
	header('Location: /?page=accueil');      
}
?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['langue'] ; ?>">

<head>
	
	<!-- CSS ressources -->
	<link rel="stylesheet" href="/ressources/css/yeti.min.css" title='default'>
	<link rel="stylesheet" href="/ressources/css/tether.min.css"> 
	<link rel="stylesheet" href="/ressources/css/bootstrap-overcode.css"> 
	<link rel="stylesheet" href="/ressources/css/principaux.css"> 
	<link rel="stylesheet" href="/ressources/css/details.css">
	<link rel="stylesheet" href="/ressources/css/elements.css">
	<link rel="stylesheet" href="/ressources/css/simple-sidebar.css"> 
	<link rel="stylesheet" href="/ressources/css/chat.css">
	
	<link rel="shortcut icon" href="/ressources/favicon.ico" type="image/x-icon" />
	
	<!-- Metas Infos ressources -->
	<meta name="keywords" content="eledentary, dental">
	<meta name="description" content="<?php echo $siteconfig->websiteMoto() ;?>">
	<meta charset="UTF-8">
	<meta name="author" content="A. Touati, J-A. Bossu">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title><?php echo $siteconfig->websiteTitle() ; ?></title>

	<!-- Bootstrap ressources -->
	<script src="/ressources/js/jquery-2.1.4.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script src="/ressources/js/custom.js"></script>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>

	<script>
	$("#menu-toggle").click(function(e) {
		e.preventDefault();
		$("#wrapper").toggleClass("toggled");
	});

	$(function () {
		$('a').tooltip( {placement: 'right', trigger:'hover'} );
	});
	</script>

<?php

echo '<!--' ;

//include('README.txt') ;

echo '-->' . "\n" ;
?>

</head>
