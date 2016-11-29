<?php
function str_starts_with($haystack, $needle)
{
    return strpos($haystack, $needle) === 0;
}

$ref = $siteconfig->websiteLanguage();
$cur = $_SESSION['langue'] ;

$lg_ref = fopen('langues/'.$ref.'.php', 'r+');
$lg_cur = fopen('langues/'.$cur.'.php', 'r+');

// Array structure
// array = [ keyword, [ ref , cur ] ]
$file = array();

while (!feof($lg_ref)) 
{
	$line_of_text = fgets($lg_ref);
	if( str_starts_with( $line_of_text, '\'') )
	{
		//print $line_of_text . "<br/>";
		$keyword = preg_replace("#\'|\t#", "", explode( "=>", $line_of_text )[0] );
		$ref_value =explode( "=>", $line_of_text )[1];
		$ref_value = preg_replace("#(,\n)|(\")|(\t)|(\")#", "", $ref_value );
	}
	elseif( str_starts_with( $line_of_text, '//') )
	{
	}
	
	if($keyword != 'endoffile')
	{
		$file[$keyword] = array( 'ref' => $ref_value, 'cur' => '' ); 
	}
}

while (!feof($lg_cur)) 
{
	$line_of_text = fgets($lg_cur);
	if( str_starts_with( $line_of_text, '\'') )
	{
		//print $line_of_text . "<br/>";
		$keyword = preg_replace("#\'|\t#", "", explode( "=>", $line_of_text )[0] );
		$value = explode( "=>", $line_of_text )[1];
		$cur_value = preg_replace("#(,\n)|(\")|(\t)|(\")#", "", $value );
	}
	
	if($keyword != 'endoffile')
	{
		$file[$keyword]['cur'] = $cur_value ; 
	}	
}
array_shift($file);

$modified = array() ;
foreach($_POST as $keyword => $value)
{
	if ( $file[$keyword]['cur'] != $value )
	{
		$file[$keyword]['cur'] = $value ;
	}
}

$newTrad = "<?php \$traduction = array (\n" ;
foreach( $file as $keyword => $value)
{
	$newTrad .= "'" . $keyword . "'\t=>\t\"". $value['cur'] .'",' ."\n" ;
}
$newTrad .= "'endoffile'=>'donottranslate');";


@ftruncate($lg_cur, 0);
fseek($lg_cur, 0);
fputs($lg_cur, $newTrad);


fclose($lg_ref);
fclose($lg_cur);
?>
