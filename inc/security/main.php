<?php
function disp_errmsg() {
    require 'security_errmsg.php';
    exit();
}

$http_referer = False;
$tokens = True;
$posts = True;
$url = True;

require 'http_referer.php';
require 'tokens.php';
require 'posts.php';
require 'url.php';