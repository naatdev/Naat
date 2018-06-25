<?php
/*
    Chargement de toutes les librairies nécessaires et de la bdd de l'utilisateur
*/
$data_access = new data_access();
$colors_lib = new giveColorFromEquivalent();
$db = new SQLite3('MNT_DB/'.$data_access->user_block($_SESSION['userName']).$data_access->user_path($_SESSION['userName']).'/data.db');
$db->busyTimeout(10000);
?>
<div id="page_content">
    <div class="row">
        <div class="col col-padding col-lg-10">
            <p class="page_title">
                Voici la liste des personnes que vous pourriez connaitre
            </p>
            <br />
        </div>
    </div>
    <div class="clear"></div>
</div>