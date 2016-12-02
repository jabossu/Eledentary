<div class='loginbody'>
<?php
$l = '' ;
foreach( $listelangues as $nom => $code )
{
	if ( $code == $_SESSION['langue'] )
	{
		$selected = 'current_language' ;
	}
	else
	{
		$selected = '' ;
	}
	
	$l .=  "\t<a href='/?langue=". $code ."'><img src='ressources/images/flag-". $code .".jpg' class='". $selected ."' alt='Drapeau ". $nom ."' /></a>" ; 
}

?>

<div class="row">
	<div class='col-md-12'>
		<?php echo '<h2>'.$l.'</h2>' ;?>
	</div>
</div>

<div class='row'>
<?php

classe('o', "col-sm-12 col-md-4 col-md-push-4");
echo '<div class="logintitle">';
	echo '<img src="/ressources/images/logo.png"></img>';
echo '</div>';
echo '<div class="loginbox">';
	if ( !isset( $_SESSION['profile'] ) )
	{
	?>
	<form method="post" action='/?page=connexion'>
		<input class="topline field" placeholder="<?php display('matricule')?>" type="text" name="matricule"/><br/>
		<input class="bottomline field" placeholder="<?php display('motDePasse')?>"  type="password" name="motDePasse" /><br/>
		<input class="sumbit" type="submit" value="Log in" >
	</form>
	
	<?php
	}
	echo '<div class="loginlinks">';
	echo '<a href="/?page=reset_password">' . translate('forgot_password') . '</a>';
	if ( $siteconfig->allowRegister() == 'on' )
	{	echo '<a href="/?page=inscription">' . translate('inscription') . '</a>';	}
	echo '</div>';
echo '</div>';
classe('c');
?>
</div>
</div>
