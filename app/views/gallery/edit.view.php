<?php
if(isset($_GET['id']) AND !empty($_GET['id']) AND is_numeric($_GET['id'])) {
    $data_access = new data_access();
    $tempSecureImage = new tempSecureImage();
    $emojis = new emojis();
    $me = True;
    $db = new SQLite3('MNT_DB/'.$data_access->user_block($_SESSION['userName']).$data_access->user_path($_SESSION['userName']).'/data.db');
    $db->busyTimeout(10000);
    $photoexists = $db->query('SELECT count("ID") as ct_id FROM "listing_media" WHERE "TYPE" = "PIC" AND "PRIVACY" != "0" AND "ID" = "'.$_GET['id'].'"')->fetchArray()['ct_id'];
    if($photoexists != 0) {
        $infos_photos = $db->query('SELECT * FROM listing_media WHERE "TYPE" = "PIC" AND "PRIVACY" != "0" AND "ID" = '.$_GET['id']);
        while($row = $infos_photos->fetchArray()) {
            $title = $row['TITLE'];
            $content = $row['CONTENT'];
            $url = $row['URL'];
            $url_ = $tempSecureImage->createTempPic($row['URL']);
        }
        if(isset($_GET['del'])) {
            if($db->query('UPDATE listing_media SET "PRIVACY" = "0" WHERE "ID" = '.$_GET['id'])) {
                ?>
                <div id="page_content">
                    <div class="row">
                        <div class="col col-padding col-lg-10 col-sm-10">
                            <p class="info">Cette photo a été supprimée de la galerie!&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>gallery" class="gallery-edit-link">retour à la galerie</a></p>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                <?php
            }
        }
        else{
            ?>
                <div id="page_content">
                    <div class="row">
                        <div class="col col-padding col-lg-10 col-sm-10">
                            <h1 class="page_title">Modifier une image</h1><br /><br />
                            <form method="POST" action="" id="gallery-add-picture">
                                <input type="text" name="title" value="<?php if(isset($_POST['title']) AND !empty($_POST['title'])) {echo $_POST['title'];}else{echo $title;} ?>" placeholder="Titre de l'image" onfocus="dispSomeHelp('La taille ne peut excéder 1000 caractères pour ce champ texte !');" />
                                <textarea name="description" placeholder="Description de l'image" rows="4" onfocus="dispSomeHelp('La taille ne peut excéder 10000 caractères pour ce champ texte !');"><?php if(isset($_POST['description']) AND !empty($_POST['description'])) {echo $_POST['description'];}else{echo $content;} ?></textarea>
                                <input type="submit" name="upload" value="Mettre à jour la photo" class="form_input_submit_login" onclick="dispLoadingIcon('Enregistrement de votre image ...');">
                            </form>
                            <?php
                                if(isset($_GET['success'])) {
                                    ?>
                                    <div class="col col-padding col-lg-10 col-sm-10">
                                        <p class="info">Cette photo a été modifiée!&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>gallery" class="gallery-edit-link">retour à la galerie</a></p>
                                    </div>
                                    <?php
                                }
                                if(isset($_POST['upload']) AND isset($_POST['title']) AND isset($_POST['description']) AND strlen($_POST['title'] < 1001) AND strlen($_POST['description'] < 10001)) {
                                    $title = $_POST['title'];
                                    $content = $_POST['description'];
                                    $db->query('UPDATE listing_media SET "TITLE" = "'.$title.'", "CONTENT" = "'.$content.'" WHERE "ID" = "'.$_GET['id'].'"');
                                    Header("Location: ".$_SESSION['NAAT_GOTO_URL']."pic_edit?success&id=".$_GET['id']);
                                    exit();
                                }
                            ?>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            <?php
        }
    }
    else{
        $error = True;
    }
}
else{
    $error = True;
}
if($error == True) {
    ?>
    <div id="page_content">
        <div class="row">
            <div class="col col-padding col-lg-10 col-sm-10">
                <p class="error">Une erreur est survenue&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>gallery" class="gallery-edit-link">retour à la galerie</a></p>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <?php
}
?>