<?php
$data_access = new data_access();
$tempSecureImage = new tempSecureImage();
$emojis = new emojis();
$me = True;
if(isset($_GET['user']) AND !empty($_GET['user']) AND ctype_alnum($_GET['user'])) {
    if($data_access->get_($data_access->user_block($_GET['user']), $_GET['user'], "username")) {
        $user = $_GET['user'];
        $db_ = new SQLite3('MNT_DB/'.$data_access->user_block($user).$data_access->user_path($user).'/data.db');
        $db_->busyTimeout(10000);
        $visibleForMe = $db_->query('SELECT count("ID") as ct_id FROM "listing_bubles_who" WHERE "USERNAME" = "'.$_SESSION['userName'].'"')->fetchArray()['ct_id'];
        if($visibleForMe != 0) {
            $user = $_GET['user'];
            $me = False;
            if($user == $_SESSION['userName']) {
                $me = True;
            }
        }
        else{
            $user = $_SESSION['userName'];
            $errorVisible = "<div class='col col-lg-10'><p class='error'>Vous n'êtes pas autorisé à consulter cette galerie !<br />(L'utilisateur n'existe pas ou plus ou alors ses paramètres de confidentialité vous empêchent d'accèder à sa galerie photo)<br />Voici votre galerie à la place.</p></div>";
            $me = False;
        }
    }
    else{
        $user = $_SESSION['userName'];
        $me = True;
        Header("Location: ".$_SESSION['NAAT_GOTO_URL']."gallery");
        exit();
    }
}
else{
    $user = $_SESSION['userName'];
    $me = True;
}
$db = new SQLite3('MNT_DB/'.$data_access->user_block($user).$data_access->user_path($user).'/data.db');
$db->busyTimeout(10000);
$max_on_page = 30;
if(isset($_GET['ID']) AND is_numeric($_GET['ID'])) {
    $start = intval($_GET['ID']);
    $liste_photos = $db->query('SELECT * FROM listing_media WHERE "TYPE" = "PIC" AND "PRIVACY" != "0" AND "ID" < '.$start.' ORDER BY ID DESC LIMIT '.$max_on_page);
}
else{
    $liste_photos = $db->query('SELECT * FROM listing_media WHERE "TYPE" = "PIC" AND "PRIVACY" != "0" ORDER BY ID DESC LIMIT '.$max_on_page);
}
?>

<div id="page_content_gallery">
    <div class="row">
        <div class="col col-padding col-lg-10 col-sm-10">
            <span class="page_title">Galerie photos <small><?php echo "@".$user; ?></small></span>
        </div>
        <div class="col col-padding col-lg-10 col-sm-10">
            <?php
                if($me == True) {
                    ?>
                    <p class="small_indic">
                        Voici votre galerie photo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="<?php echo $_SESSION['NAAT_GOTO_URL'] ?>pic_add" class="gallery-edit-link">Mettre en ligne une photo</a>
                    </p>
                    <?php
                }
                else{
                    ?>
                    <p class="small_indic">
                        Voici la galerie photo de <?php echo "@".$user; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="<?php echo $_SESSION['NAAT_GOTO_URL'] ?>profile?profile_id=<?php echo $user; ?>" class="gallery-edit-link">Voir le profil de <?php echo "@".$user; ?></a>
                    </p>
                    <?php
                }
            ?>
            <br /><br />
        </div>
        <?php if($me == True) { ?>
        <a href="<?php echo $_SESSION['NAAT_GOTO_URL'] ?>pic_add" onclick="dispLoadingIcon('Veuillez patienter ...');">
            <div class="col col-lg-2 col-padding gallery-thumb gallery-add">
                Ajouter une photo
            </div>
        </a>
        <?php } ?>
        <?php if(isset($errorVisible)) { echo $errorVisible; } ?>
        <?php
            $i = 0;
            $id = 0;
            while($row = $liste_photos->fetchArray()) {
                $i++;
                $id = $row['ID'];
                $url_image = $_SESSION['NAAT_ORIGIN_DIRECTORY'].'/'.$tempSecureImage->createTempPic($row['URL']);
                ?>
                <a href="<?php echo $_SESSION['NAAT_GOTO_URL'].'pic_view?gallery='.$user.'&pic='.$row['ID']; ?>" onclick="dispLoadingIcon('Chargement de l'image ...');">
                    <div class="col col-lg-2 col-padding gallery-thumb gallery-thumb-effect" style="background-image: url('<?php echo $url_image; ?>'); animation-duration: <?php echo $i/rand(1,5); ?>s;">
                        <?php if(!empty($row['TITLE'])) { ?>
                            <p><?php echo substr($row['TITLE'], 0, 45); if(strlen($row['TITLE']) > 45) { echo "..."; } ?></p>
                        <?php } ?>
                    </div>
                </a>
                <?php
            }
            if($i > ($max_on_page-1)) {
                ?>
                <a href="?ID=<?php echo $id; if(isset($user) AND $user != $_SESSION['userName']) { echo "&gallery=".$user; } ?>" onclick="dispLoadingIcon('Veuillez patienter ...');">
                    <div class="col col-lg-2 col-padding gallery-thumb gallery-more">
                        Afficher la suite
                    </div>
                </a>
                <?php
            }
            if(isset($start)) {
                ?>
                <a href="?ID=" onclick="dispLoadingIcon('Veuillez patienter ...');">
                    <div class="col col-lg-2 col-padding gallery-thumb gallery-more">
                        Retour à la liste
                    </div>
                </a>
                <?php
            }
            if($i == 0) {
                ?>
                <div class="col col-lg-2 col-padding gallery-thumb gallery-more">
                    Aucune photo pour le moment
                </div>
                <?php
            }
        ?>
    </div>
    <div class="clear"></div>
</div>