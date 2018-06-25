<?php
$data_access = new data_access();
$db = new SQLite3('MNT_DB/'.$data_access->user_block($_SESSION['userName']).$data_access->user_path($_SESSION['userName']).'/data.db');
$db->busyTimeout(10000);
$unreadMsg = $db->query('SELECT count("ID") as ct_id FROM listing_messages WHERE "SEEN" = "0" AND "TO" = "'.$_SESSION['userName'].'"')->fetchArray()['ct_id'];
$_SESSION['unreadMsgStr'] = "<span class='badge_count' id='counterSpanMsg'>".$unreadMsg."</span>&nbsp;&nbsp;";
$_SESSION['unreadMsg'] = $unreadMsg;
if($_SESSION['unreadMsg'] > 9) {
    $_SESSION['unreadMsg'] = "+9";
}
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <title>naät - @<?php echo $_SESSION['userName']; ?></title>
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
        <link rel="stylesheet" href="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/css/user_space.css" />
        <link rel="stylesheet" href="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/fonts/css/fontawesome-all.min.css" />
        <style type="text/css">
            <?php include('inc/template/css/user.css.php'); ?>
        </style>
        <link rel="stylesheet" href="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/css/simplemde.min.css">
    </head>
    
    <body>
        <div id="top_help" style="display:none;">
            <img src="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/icons/info.svg" id="info_icon" />
            <p id="top_help_disp"></p>
            <br />
            <a onclick="document.getElementById('top_help').style = 'display:none;';">&times; fermer cette fenêtre</a>
        </div>
        
        <div id="loading_icon" style="display:none;">
            <div id="loading_blue_block"></div>
            <p id="toolong" style="opacity:0;">Le temps de chargement est anornalement long ...<br />Merci de patienter</p>
            <p id="loading_info"></p>
        </div>
        
        <?php $this->viewLoad('parts/loged_top_bar'); ?>

        <div id="left_sidebar">
            <?php $this->viewLoad('parts/loged_left_menu'); ?>
        </div>
