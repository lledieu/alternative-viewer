<?php

/*
 *  Turn all notices / warnings into an exception
 *   usefull on development environnement
 *   rename the file noinc_optional.php to inc_optional.php to active it
 */
function exception_error_handler($errno, $errstr, $errfile, $errline ) {
    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
}
set_error_handler("exception_error_handler");
?>
