<?php
$page_title = 'Bienvenue sur naät';
if(isset($_GET['login_form'])) {
    $page_title = 'Se connecter';
}
if(isset($_GET['register_form'])) {
    $page_title = 'Créer un compte';
}
if($_SESSION['NAAT_REQUEST'] == 'about') {
    $page_title = 'A propos de naät';
}
if($_SESSION['NAAT_REQUEST'] == 'legals') {
    $page_title = 'Mentions légales';
}
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <title><?php echo $page_title; ?> </title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no" />
        <meta name="theme-color" content="#333333" />
        <meta name="mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="white" />
        <meta name="description" content="naät est un réseau social" />
        <meta name="author" content="Florian Hourdin, Efekan Gocer, Thomas Lepillez" />
        <link rel="stylesheet" href="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/css/grid.css" />
        <link rel="stylesheet" href="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/css/common.css" />
        <link rel="stylesheet" href="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/css/login.css" />
    </head>
    
    <body>
        <div id="top_help" style="display:none;">
            <img src="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/icons/info.svg" id="info_icon" />
            <p id="top_help_disp"></p>
            <br />
            <a class="top_help_close" onclick="document.getElementById('top_help').style = 'display:none;';">&times; fermer cette fenêtre</a>
        </div>
                
        <div id="loading_icon" style="display:none;">
            <div id="loading_blue_block"></div>
            <p id="toolong" style="opacity:0;">Le temps de chargement est anornalement long ...<br />Merci de patienter</p>
        </div>

        <div id="top_header_background"></div>

        <div id="top_header" class="row">
            <span class="title columnShow3">
                Bienvenue sur naät !
            </span>
            <p class="description columnShow4">
                Avec un bon navigateur et toute la puissance de naät,<br /> Restez en contact avec les autres personnes !
                <br />
                Connectez-vous ou inscrivez vous afin de continuer
            </p>
            <div id="top_header_buttons" class="columnShow5">
                <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>login?login_form"><button class="login">Je me connecte</button></a>
                <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>login?register_form"><button class="register">créer un compte</button></a>
            </div>
        </div>
        <div class="clear"></div>

        <div id="login_page">
            <a name="page_content"></a>
            