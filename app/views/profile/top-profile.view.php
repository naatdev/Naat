<?php
$data_access = new data_access();
$tempSecureImage = new tempSecureImage();
$emojis = new emojis();
$months = array(
    "01" => "janvier",
    "02" => "février",
    "03" => "mars",
    "04" => "avril",
    "05" => "mai",
    "06" => "juin",
    "07" => "juillet",
    "08" => "aout",
    "09" => "septembre",
    "10" => "octobre",
    "11" => "novembre",
    "12" => "décembre"
    );

$username = htmlspecialchars($_GET['profile_id']);
$db = new SQLite3('MNT_DB/'.$data_access->user_block($username).$data_access->user_path($username).'/data.db');
$db->busyTimeout(10000);

$presentation = $data_access->get_($data_access->user_block($username), $username, "presentation");
$bioNonVisible = "<p class='error'>@".$username." n'a pas de biographie pour le moment.</p>";
if(empty($presentation)) {
    $presentation = $bioNonVisible;
}
?>

<div class="row profile">
    <div class="col col-lg-3">
        <div class="profile-pic" style="background-image:url('<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY'].'/'.$tempSecureImage->createTempPic($data_access->get_($data_access->user_block($username), $username, "avatar")); ?>');'" onclick="openProfilePic();"></div>
    </div>
    <div class="col col-lg-7">
        <div class="row">
            <div class="col col-lg-6">
                <span class="name"><?php echo $data_access->get_($data_access->user_block($username), $username, "nom_reel"); ?></span></span>
                <br />
                <span class="username">@<?php echo $username; ?></span>
            </div>
            <div class="col col-lg-4 col-text-align-right">
                <p class="location_gender">
                    <img src="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/icons/svg/placeholder-3.svg" class="icon" />
                    <?php echo $data_access->get_($data_access->user_block($username), $username, "ville"); ?>
                    &nbsp;&nbsp; - 
                     &nbsp;&nbsp;<?php echo $data_access->get_($data_access->user_block($username), $username, "genre"); ?>
                </p>
            </div>
            <div class="col col-lg-10">
                <?php
                    $postsVisibles = 0;
                    $bioVisible = $db->query('SELECT "VALUE" as ct_id FROM "listing_infos" WHERE "NAME" = "confidentialVisibleBio"')->fetchArray()['ct_id'];
                    $visibleForMe = $db->query('SELECT count("ID") as ct_id FROM "listing_bubles_who" WHERE "USERNAME" = "'.$_SESSION['userName'].'"')->fetchArray()['ct_id'];
                    
                    if($bioVisible == 1) {
                        $bioVisible = 1;
                    }
                    if($bioVisible == 0 AND $visibleForMe != 0) {
                        $bioVisible = 1;
                    }
                
                    if($username == $_SESSION['userName'] OR $bioVisible == 1) {
                        ?>
                        <div class="biography"><?php echo nl2br($emojis->transformtoSvg($presentation)); ?></div>
                        <?php
                    }
                    else{
                        ?>
                        <div class="biography"><?php echo $bioNonVisible; ?></div>
                        <?php
                    }
                ?>
                <div class="col col-lg-3">
                    <a name="bubleAdd" style="display: none;">&nbsp;&nbsp;</a>
                    <form method="POST" action="#bubleAdd" class="add_buble">
                        <select name="add_to_buble" class="settings-select" onchange="this.form.submit();">
                            <option value="" disabled="true" selected="true">Ajouter @<?php echo $username; ?> à ...</option>
                            <?php
                                $db_my = new SQLite3('MNT_DB/'.$_SESSION['currentUserBlock'].'/'.$data_access->user_path($_SESSION['userName']).'/data.db');
                                $listBubles = $db_my->query('SELECT ID,NAME FROM listing_bubles ORDER BY ID desc');
                                $posibles = array();
                                while($row = $listBubles->fetchArray()) {
                                    $posibles[] = $row['ID'];
                                    ?>
                                    <option value="<?php echo $row['ID']; ?>"><?php echo $row['NAME']; ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </form>
                    <?php
                        if(isset($_POST['add_to_buble']) AND !empty($_POST['add_to_buble'])) {
                            if(in_array($_POST['add_to_buble'], $posibles)) {
                                $isAlreadyIn = $db_my->query('SELECT count(ID) as ct_id FROM listing_bubles_who WHERE "USERNAME" = "'.$username.'" AND "BUBLE_ID" = "'.$db_my->escapeString($_POST['add_to_buble']).'"')->fetchArray()['ct_id'];
                                if($isAlreadyIn > 0) {
                                    echo "<br /><p class='info'>".$username." en fait déjà parti</p><br />";
                                }
                                if($isAlreadyIn < 1) {
                                    $countInBuble = $db_my->query('SELECT count("ID") as ct_id FROM listing_bubles_who WHERE "BUBLE_ID" = "'.$db_my->escapeString($_POST['add_to_buble']).'"')->fetchArray()['ct_id'];
                                    if($countInBuble < 100) {
                                        if($db_my->query('INSERT INTO listing_bubles_who("USERNAME","BUBLE_ID","ADD_TIME") VALUES("'.$username.'","'.$db_my->escapeString($_POST['add_to_buble']).'","'.time().'")')) {
                                            echo "<br /><p class='success'>Ajouté  !</p><br />";
                                        }
                                        else{
                                            echo "<br /><p class='error'>Erreur</p><br />";
                                        }
                                    }
                                    else{
                                        echo "<br /><p class='error'>Trop de monde dans cette bulle (maximum 100)</p><br />";
                                    }
                                }
                            }
                        }
                    ?>
                </div>
                <div class="col col-lg-4 col-text-align-center">
                    <div class="last-online">
                        <?php
                            if(intval($db->query('SELECT "VALUE" as ct FROM listing_infos WHERE "NAME" = "confidentialVisibleOnline"')->fetchArray()['ct']) == 1) {
                                $intValLastOnline = intval($db->query('SELECT "VALUE" as ct FROM listing_infos WHERE "NAME" = "last_online"')->fetchArray()['ct']);
                                $lastOnline = time()-$intValLastOnline;
                                if($lastOnline < 60) {
                                    $lastOnline = "< 1 min";
                                }
                                elseif($lastOnline > 59 AND $lastOnline < 61) {
                                    $lastOnline = "1 min";
                                }
                                elseif($lastOnline > 60 AND $lastOnline < 3600) {
                                    $minutes = round(($lastOnline/60),0);
                                    $lastOnline = $minutes." min";
                                    if($minutes > 1) {
                                        $lastOnline .= "s";
                                    }
                                }
                                elseif($lastOnline > 3599 AND $lastOnline < 3601) {
                                    $lastOnline = "une heure";
                                }
                                elseif($lastOnline > 3600 AND $lastOnline < 86400) {
                                    $heures = round(($lastOnline/3600),0);
                                    $lastOnline = $heures." heure";
                                    if($heures > 1) {
                                        $lastOnline .= "s";
                                    }
                                }
                                elseif($lastOnline > 86399 AND $lastOnline < 86401) {
                                    $lastOnline = "un jour";
                                }
                                else{
                                    $jours = round(($lastOnline/86400),0);
                                    $lastOnline = $jours." jour";
                                    if($jours > 1) {
                                        $lastOnline .= "s";
                                    }
                                }
                        ?>
                            <span class="small_indic"><img src="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/icons/svg/checked.svg" class="icon" />&nbsp;&nbsp;En ligne il y a <?php echo $lastOnline; ?></span>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="clear"></div>
<div class="row profile">
    <div class="col col-lg-3">
        <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>messages?group=new&dest=<?php echo $username; ?>" class="contact">
            <img src="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/icons/svg/dialogue/chat-26.svg" class="icon" /> Envoyer un message
        </a>
        <br /><br />
        <?php
            $galleryvisibleForMe = $db->query('SELECT count("ID") as ct_id FROM "listing_bubles_who" WHERE "USERNAME" = "'.$_SESSION['userName'].'"')->fetchArray()['ct_id'];
            if($galleryvisibleForMe != 0) {
                ?>
                <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>gallery?user=<?php echo $username; ?>" class="gallery">
                    <button><i class="fa fa-camera"></i>&nbsp; Galerie photo</button>
                </a>
                <div class="row profile-preview-gallery">
                <?php
                    $liste_photos = $db->query('SELECT * FROM listing_media WHERE "TYPE" = "PIC" AND "PRIVACY" != "0" ORDER BY ID DESC LIMIT 10');
                    while($row = $liste_photos->fetchArray()) {
                        $id = $row['ID'];
                        $url_image = $_SESSION['NAAT_ORIGIN_DIRECTORY'].'/'.$tempSecureImage->createTempPic($row['URL']);
                ?>
                    <a href="<?php echo $_SESSION['NAAT_GOTO_URL'].'pic_view?pic='.$id.'&gallery='.$username; ?>" target="_blank">
                        <div class="col col-lg-10">
                            <img src="<?php echo $url_image; ?>" />
                        </div>
                    </a>
                <?php
                    }
                ?>
                </div>
                <div class="clear"></div>
                <?php
            }
        ?>

    </div>
    <div class="col col-lg-7 posts">
        <?php
            include_once("posts-profile.view.php");
        ?>
    </div>
</div>
<div class="clear"></div>