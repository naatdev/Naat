<?php
/**
* Code pour la récupération du nombre de messages non lus
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
header("Content-Type: application/javascript");
if(isset($_SESSION['userName'])) {
    $db = new SQLite3('./MNT_DB/'.$data_access->user_block($_SESSION['userName']).$data_access->user_path($_SESSION['userName']).'/data.db');
    $db->busyTimeout(10000);

    $unreadMsg = $db->query('SELECT count("ID") as ct_id FROM listing_messages WHERE "SEEN" = "0" AND "TO" = "'.$_SESSION['userName'].'"')->fetchArray()['ct_id'];
    $unreadMsgStr = $unreadMsg > 0 ? "<span class='badge_count'>".$unreadMsg."</span>" : "";
    $nbrNotifs = $unreadMsg;
    
    if($nbrNotifs > 9) {
      $nbrNotifs = "+9";
    }

    if(!isset($_GET['top_bar']) AND !isset($_GET['code']) AND !isset($_GET['nbr'])) {
      echo $unreadMsgStr;
    }
    else{
      if(!isset($_GET['nbr'])) {
        if(!isset($_GET['code'])) {
          echo $nbrNotifs;
        }
        else{
          if($nbrNotifs > 0) {
             $str = " - ".$nbrNotifs." message(s)";
          }
          else{
            $str = "";
          }
          echo "function changeTitle() { document.title = 'naät ".$str."'; }";
        }
      }
      else{
        echo $nbrNotifs;
      }
    }
}