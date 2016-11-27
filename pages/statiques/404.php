<!--	Page 404	-->
<?php

echo '<div id=corps>';

classe('o', 'page-header') ;
display('404_title', 'h1') ;
classe('c');

display('404_msg', '', $_GET['page']) ;

echo "</div>" ;
