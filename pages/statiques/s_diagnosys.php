<h1>Diagnostic</h1>

<?php

# Use this page in your developement to create tests and function
# and display them as you wish in the user interface.
# This file has been added in the gitignoer file

$password = "kangourou";

$hash = my_encrypt( $password );

show($password);
show($hash);
show( my_decrypt( $password.'h', $hash ) );

if (my_decrypt( $password, $hash )) {
    echo "true";
}
else {
    echo "false";
}
