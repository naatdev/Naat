<?php
/*
    Premier niveau de protection TOKENS
    Contre les attaques CSRF
*/
if(isset($_SESSION['userName']) AND !isset($_SESSION['token'])) {
    $token = hash("sha256", uniqid().rand(0,10000)).hash('sha1', rand(0,10000).uniqid());
    $_SESSION['token'] = $token;
}
