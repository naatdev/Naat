<?php
/*
    Premier niveau de protection HTTP_REFERER
    Contre les attaques HTTP_REFERER
*/
if($http_referer == True AND isset($_SERVER['HTTP_REFERER']) AND $_SERVER['HTTP_REFERER'] != $_SESSION['NAAT_ORIGIN_DIRECTORY']) {
    disp_errmsg();
}
