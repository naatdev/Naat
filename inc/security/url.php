<?php
/*
    Vérification des urls
*/
$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if($url == True AND (preg_match("#\"|'|\%22|\%27#", $actual_link))) {
    disp_errmsg();
}
