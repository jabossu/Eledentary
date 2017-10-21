<h1>Diagnostic</h1>
<pre>
<?php

echo '<h2>$_SESSION</h2>';
print_r($_SESSION);


echo ($_POST == array() ) ?1 :0  ;

?>
</pre>

<?php

$f = new form('classic', "boom" ) ;
$f->input('nom', "test", 'text', "hello", 'Name' );
$f->submit( translate('register') ) ; # submit button
$f->output() ;


