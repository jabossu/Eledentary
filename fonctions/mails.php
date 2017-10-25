<?php

function composerMail($src, $name, $forname, $matricule, $objet, $more=null)
{
	$filename = "ressources/mails/" . $src;
	$fp = fopen($filename, "r");
	$model = fread($fp, filesize($filename));
	fclose($fp);
	
	
	$model = str_replace("\n", "<br/>\r\n", $model) ;
	$model = str_replace("%SRV%",		$_SERVER['SERVER_NAME'].'/',		$model) ;
	$model = str_replace("%NOM%",		$name,		$model) ;
	$model = str_replace("%PRENOM%",	$forname,		$model) ;
	$model = str_replace("%MATRI%",		$matricule,		$model) ;
	$model = str_replace("%MORE%",		$more,		$model) ;
	$model = wordwrap($model, 75, "<br/>\r\n");
	
	
	$message = 
"<html>
	<head>
	<title>" . $objet . "</title>
	</head>
<body>
	<p>" . $model . "</p>
</body>
</html>";
	
	return $message ;
}

function envoyerMail(eleve $destinataire, $objet, $src, $more=null)
{
	if ( file_exists( 'ressources/mails/' . $src ) )
	# If the mail model exists, we load it and replace keywords with values
	{
		$message = composerMail($src, $destinataire->nom(), $destinataire->prenom(), $destinataire->matricule(), $objet, $more) ;
	}
	else
	# If not, we stop there and raise an exception
	{	throw new Exception("Mail model could not be found");	}
	
	#Setting few variables for sending the mail
	$from= "\"Patients Dentaires\" <gpdentaire-auto@cmcluj.fr>";
	$to  = $destinataire->email();
	
	#composing the mail headers
	$headers = 'From: ' . $from . "\r\n";
	$headers .= 'Reply-To: '. $from . "\r\n";
	$headers .= 'MIME-Version: 1.0' . "\r\n" ;
	$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n" ;
	
	#Sending the mail and checking if it worked
	if ( mail($to ,$objet , $message, $headers) == false ) ;
	{	throw new Exception("Mail could not be send");	}
	
}

function mailPatient(patient $destinataire, $objet, $src, $more=null)
{
	if ( file_exists( 'ressources/mails/' . $src ) )
	{
		$message = composerMail($src, $destinataire->nom(), $destinataire->prenom(), '00000', $objet, $more) ;
	}
	else
	{
		$message = null ;
	}
	
		
	if ( $message != null )
	{
		$from= "\"Patients Dentaires\" <gpdentaire-auto@cmcluj.fr>";
		$to  = $destinataire->email();

		$headers = 'From: ' . $from . "\r\n";
		$headers .= 'Reply-To: '. $from . "\r\n";
		$headers .= 'MIME-Version: 1.0' . "\r\n" ;
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n" ;
	
		if ( mail($to ,$objet , $message, $headers) == false )
		{
			echo '<pre>[ Mail error : Mail not send ]</pre>' ;
		} 	
	}
	else
	{
		echo '<pre>[ Mail error : model not found ]</pre>' ;
	}
}
