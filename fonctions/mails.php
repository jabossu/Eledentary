<?php

function model_exists(string $model_name)
{
	$result = false;
	$sources="ressources/mails/";
	foreach ( scandir($sources) as $filename ) {
		if ( preg_match("#-".$model_name."$#", $filename ) ) {
			$result = true ;
		}
	}
	return $result;
}

function compile_mail(string $template, string $object, array $options=null, string $lang="all")
{
	$message = "";
	$stylesheet = "ressources/css/emails.css";
	$sp = fopen($stylesheet, "r");
	$css = fread($sp, filesize($stylesheet));
	fclose($sp);

	$list_templates = array() ; $sources="ressources/mails/";
	foreach (scandir($sources) as $filename) {
		if ( preg_match("#-".$template."$#", $filename ) ) {
			$list_templates[] = $sources.$filename ;
		}
	}
	
	if ( $list_templates == array() ) {
		exit(0);
	}

	$message .= "<html><head>\n\t<style>" . $css . "</style>\n\t<title>" . $object . "</title>\n\t</head>\n<body>";
	
	$message .= "
<table>	
	<tr>
		<th>".$object."</th>
	</tr>";
	foreach ($list_templates as $language) {
		
		$fp = fopen($language, "r");
		$text = fread($fp, filesize($stylesheet));
		fclose($fp);
		
		$text = str_replace("\n", "<br/>\r\n", $text) ;
		$text = str_replace("%SRV%", $_SERVER['SERVER_NAME'], $text) ;
		foreach ($options as $key => $value) {
			$text = str_replace("%".$key."%", $value, $text) ;
		}
		
		$message .= "<tr>
		<td>".$text."</td>
	</tr>";
	}
	$message .= "<tr><td id='tablefoot'>This mail was send automaticaly by Eledentary Patient Manager</td></tr>";
	$message .= "</table>";	
	
	
	$message .= "</body></html>";
	
	return $message;
}

function envoyerMail(eleve $sendto, string $objet, string $src, string $more=null, string $lang=null)
{
	if ( model_exists($src) )
	# If the mail model exists, we load it and replace keywords with values
	{
		$options = array(
			"NOM" => $sendto->nom(),
			"PRENOM" => $sendto->prenom(),
			"MATRI" => $sendto->matricule(),
			"EMAIL" => $sendto->email(),
			"MORE" => $more,
		);
		$message = compile_mail($src, $objet, $options) ;
	}
	else
	# If not, we stop there and raise an exception
	{	throw new Exception("Mail model could not be found");	}
	
	#Setting few variables for sending the mail
	$from= "\"Patients Dentaires\" <gpdentaire-auto@cmcluj.fr>";
	$to  = $sendto->email();
	
	#composing the mail headers
	$headers = 'From: ' . $from . "\r\n";
	$headers .= 'Reply-To: '. $from . "\r\n";
	$headers .= 'MIME-Version: 1.0' . "\r\n" ;
	$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n" ;
	
	#Sending the mail and checking if it worked
	return mail($to ,$objet , $message, $headers) ;
	
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


function composerMail($src, $name, $forname, $matricule, $objet, $more=null)
{
	$filename = "ressources/mails/" . $src;
	$stylesheet = "ressources/css/emails.css";
	$fp = fopen($filename, "r");
	$sp = fopen($stylesheet, "r");
	$model = fread($fp, filesize($filename));
	$css = fread($sp, filesize($stylesheet));
	fclose($fp);
	
	
	$model = str_replace("\n", "<br/>\r\n", $model) ;
	$model = str_replace("%SRV%",		$_SERVER['SERVER_NAME'],		$model) ;
	$model = str_replace("%NOM%",		$name,		$model) ;
	$model = str_replace("%PRENOM%",	$forname,		$model) ;
	$model = str_replace("%MATRI%",		$matricule,		$model) ;
	$model = str_replace("%MORE%",		$more,		$model) ;
	$model = wordwrap($model, 75, "<br/>\r\n");
	
	
	$message = 
"<html>
	<head>
	<style>" . $css . "</style>
	<title>" . $objet . "</title>
	</head>
<body>
	<p id='content'>" . $model . "</p>
</body>
</html>";
	
	return $message ;
}

