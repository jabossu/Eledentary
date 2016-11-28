<?php 
// ============= Donnees et Appels ===========

// contient les parametres de base du site, notamment la base de données
include("config.php") ; 
// contient les fonctions à appeller avant le code HTML
// notamment la $bbd et les sessions.
include("init.php") ;	

// Ajoute tout le contenu des balises <head>
include("pages/parts/header.php") ;
// Le body, avec un container fixe de bootstrap
echo '<body class="container-fluid" >';

if ( isset( $_GET['page'] ) )
{
	$page = strip_tags( $_GET['page'] ) ;
	
	if ( file_exists( 'pages/constructeurs/c_' . $page . '.php' )  )
	{
		$pageType = 'dynamic' ;
	}
	elseif ( file_exists( 'pages/statiques/s_' . $page . '_' . $_SESSION['langue'] . '.php' ) )
	{
		$pageType = 'static' ;
	}
	elseif ( file_exists( 'pages/statiques/s_' . $page . '.php' ) )
	{
		$pageType = 'rock' ;
	}
	else
	{
		$pageType = 'inexistant' ;
	}
	
	if ( $pageType != 'inexistant' )
	{
		if ($pageType == 'dynamic')
		{
			require( 'pages/constructeurs/c_' . $page . '.php' ) ;
			if ( isset($_SESSION['profile']) )
			{
				if ( $_SESSION['profile']->statut() == 'administrateur' )
				{
					$permission = 40 ;	
				}
				elseif ( isset($_GET['id']) and $_GET['id'] == $_SESSION['profile']->id() )
				{
					$permission = 35 ;
				}
				elseif ( $_SESSION['profile']->statut() == 'approuve' )
				{
					$permission = 30 ;	
				}
			}
			else
			{
				$permission = 10 ;
			}
		}
		
		if ( $permission >= $accesslevel or $pageType == 'static' or $pageType == 'rock' )
		{
			if ($pageType == 'dynamic')
			{
				require( 'pages/reflecteurs/m_'. $page .'.php' ) ;
			}
			
			// Display User bar
			comment('Userbar');
			require("pages/parts/userbar.php") ;
			

			// Middle row
			echo '<div class="row page-content-wrapper" id="wrapper">' ; 
				
				// Display Navigation Menu
				comment('Sidebar Menu');
				echo "<div id='sidebar-wrapper'>";
					require("pages/parts/menu.php") ;
				echo "</div>" ;
								
				// Display page content
				comment('Page content');
				echo '<div class="col-md-12 col-sm-12" id="full">';
					//Display the site logo in page
					echo "<div class='sitemoto text-right'><span class='moto'>". ucfirst($siteconfig->websiteMoto()) ."</span><img id='logo-corner' alt='The website logo' src='/ressources/images/logo.png'></div>";
					
					echo '<div id="corps">';
						if ($pageType == 'dynamic')
						{
							require( 'pages/afficheurs/v_'. $page .'.php' ) ;
						}
						elseif ($pageType == 'rock')
						{
							require( 'pages/statiques/s_'. $page .'.php' ) ;
						}
						else
						{
							require( 'pages/statiques/s_' . $page . '_' . $_SESSION['langue'] . '.php' ) ;
						}
				
						// Display footer
						comment('Footer');
						echo '<div class="row">' ;
							classe('o', "col-sm-12");
							require("pages/parts/footer.php");
							classe('c') ;
						echo '</div>' ;
					echo "</div>";
				classe('c') ;
				
				
			
				
			comment('End Page content');
			echo '</div>' ;
			
			
			
		}
		else
		{
			require("pages/statiques/403.php");
		}
	}
	else
	{
		require("pages/statiques/404.php");
	}
}

else
{
	if ( isset($_SESSION) and isset($_SESSION['profile']) )
	{
		header('Location: /?page=accueil');
	}	
	
	// ========================
	// 	Middle row
	// ========================

	// Conection area
	echo '<div class="row loginpage">' ; 
	require('pages/statiques/s_loginpage.php');
	echo "</div>" ;
		
}

?>
<script>
$("#menu-toggle").click(function(e) {
	e.preventDefault();
	$("#wrapper").toggleClass("toggled");
});

$(function () {
	$('a').tooltip( {placement: 'right', trigger:'hover'} );
});
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>

</body>
</html>
