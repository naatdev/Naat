<?php
/**
* Code pour actualiser l'état en ligne du membre
* On créé la réponse à afficher
* @package  Naat_ISN
* @author   Florian Hourdin <florian.hourdin59300@gmail.com>
* @version  $Revision: 1.3 $
*/
/*
    On démarre la session et on injecte les librairies nécessaires
*/
session_start();
include_once("../../app/libs/data_access.lib.php");
$data_access = new data_access("../../");

if(isset($_SESSION['userName'])) {
    $db = new SQLite3('./MNT_DB/'.$data_access->user_block($_SESSION['userName']).$data_access->user_path($_SESSION['userName']).'/data.db');
    $db->busyTimeout(10000);
    $db->query('UPDATE listing_infos SET "VALUE" = "'.time().'" WHERE "NAME" = "last_online"');
}