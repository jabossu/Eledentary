
<!-- 		Page 403 : 		-->
<?php

echo '<div id=corps>';

classe('o', 'page-header') ;
display('403_title', 'h1') ;
classe('c');

display('403_msg', 'p') ;

?>

<a href='/?page=accueil' class="btn btn-primary"><?php display('back_home') ; ?></a>
<br/>

<?php
echo "</div>" ;
