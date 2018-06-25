<?php
$data_access = new data_access();
$tempSecureImage = new tempSecureImage();
$emojis = new emojis();
if(isset($_GET['gallery']) AND !empty($_GET['gallery']) AND ctype_alpha($_GET['gallery']) AND isset($_GET['pic']) AND !empty($_GET['pic']) AND is_numeric($_GET['pic'])) {
    if($data_access->get_($data_access->user_block($_GET['gallery']), $_GET['gallery'], "username")) {
        $user = $_GET['gallery'];
        $db = new SQLite3('MNT_DB/'.$data_access->user_block($user).$data_access->user_path($user).'/data.db');
        $db->busyTimeout(10000);
        $visibleForMe = $db->query('SELECT count("ID") as ct_id FROM "listing_bubles_who" WHERE "USERNAME" = "'.$_SESSION['userName'].'"')->fetchArray()['ct_id'];
        if($visibleForMe != 0 OR $_GET['gallery'] == $_SESSION['userName']) {
            $photoexists = $db->query('SELECT count("ID") as ct_id FROM "listing_media" WHERE "TYPE" = "PIC" AND "PRIVACY" != "0" AND "ID" = "'.$_GET['pic'].'"')->fetchArray()['ct_id'];
            if($photoexists != 0) {
                $infos_photos = $db->query('SELECT * FROM listing_media WHERE "TYPE" = "PIC" AND "PRIVACY" != "0" AND "ID" = '.$_GET['pic']);
                while($row = $infos_photos->fetchArray()) {
                    $title = $row['TITLE'];
                    $content = $row['CONTENT'];
                    $url = $row['URL'];
                    $url_ = $tempSecureImage->createTempPic($row['URL']);
                }
            }
            else{
                $error = True;
            }
        }
        else{
            $error = True;
        }
    }
    else{
        $error = True;
    }
}
else{
    $error = True;
}
?>

<div id="page_content_gallery">
    <div class="row">
        <?php if(!isset($error)) { ?>
            <div class="col col-padding col-lg-10 col-sm-10">
                <span class="page_title">Photo de <small><?php echo "@".$user; ?></small></span>
            </div>
            <div class="col col-padding col-lg-3">
                <h1><?php echo $title; ?></h1>
                <br /><br />
                <p class="small_indic"><?php echo $content; ?></p>
                <br /><br />
                <p class="small_indic">Photo mise en ligne le <?php echo date("d/m/Y à H:i:s.", filectime('./'.$url)); ?></p>
                <br /><br />
                <?php
                    if($user == $_SESSION['userName']) {
                        ?>
                        <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>pic_edit?id=<?php echo $_GET['pic']; ?>" class="gallery-edit-link">Modifier cette image</a>
                        <br /><br />
                        <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>pic_edit?del&id=<?php echo $_GET['pic']; ?>" class="gallery-del-link">Supprimer cette image</a>
                        <?php
                    }
                ?>
            </div>
            <div class="col col-padding col-lg-7" style="animation-name:animPositionColumnShow;animation-duration:2s;">
                <img src="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY'].'/'.$url_; ?>" />
            </div>
        <?php }else{ ?>
            <div class="col col-padding col-lg-10 col-sm-10">
                <span class="page_title">Photo indisponible</span><br /><br />
                <p class='error'>Vous n'êtes pas autorisé à consulter cette photo !<br />(L'utilisateur n'existe pas ou plus ou alors ses paramètres de confidentialité vous empêchent d'accèder à sa galerie photo)</p>
            </div>
        <?php } ?>
    </div>
    <div class="clear"></div>
</div>