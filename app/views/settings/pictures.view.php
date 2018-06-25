<?php
/*
    La fonction qui suit (darkroom) n'est pas de nous, nous l'avons modifiée
*/
function darkroom($img, $to, $width = 0, $height = 0, $useGD = True) {
    $dimensions = getimagesize($img);
    $ratio = $dimensions[0] / $dimensions[1];
    if($width == 0 && $height == 0) {
        $width = $dimensions[0];
        $height = $dimensions[1];
    }elseif($height == 0) {
        $height = round($width / $ratio);
    }elseif ($width == 0) {
        $width = round($height * $ratio);
    }
    if($dimensions[0] > ($width / $height) * $dimensions[1]) {
        $dimY = $height;
        $dimX = round($height * $dimensions[0] / $dimensions[1]);
        $decalX = ($dimX - $width) / 2;
        $decalY = 0;
    }
    if($dimensions[0] < ($width / $height) * $dimensions[1]) {
        $dimX = $width;
        $dimY = round($width * $dimensions[1] / $dimensions[0]);
        $decalY = ($dimY - $height) / 2;
        $decalX = 0;
    }
    if($dimensions[0] == ($width / $height) * $dimensions[1]) {
        $dimX = $width;
        $dimY = $height;
        $decalX = 0;
        $decalY = 0;
    }
    if($useGD){
        $pattern = imagecreatetruecolor($width, $height);
        $type = mime_content_type($img);
        switch (substr($type, 6)) {
            case 'jpeg':
                $image = imagecreatefromjpeg($img);
                break;
            case 'jpg':
                $image = imagecreatefromjpeg($img);
                break;
            case 'gif':
                $image = imagecreatefromgif($img);
                break;
            case 'png':
                $image = imagecreatefrompng($img);
                break;
        }
        imagecopyresampled($pattern, $image, 0, 0, 0, 0, $dimX, $dimY, $dimensions[0], $dimensions[1]);
        imagedestroy($image);
        imagejpeg($pattern, $to, 100);
 
        return True;
    }else{
        $cmd = '/usr/bin/convert -resize '.$dimX.'x'.$dimY.' "'.$img.'" "'.$dest.'"';
        shell_exec($cmd);
        $cmd = '/usr/bin/convert -gravity Center -quality 70 -crop '.$largeur.'x'.$hauteur.'+0+0 -page '.$largeur.'x'.$hauteur.' "'.$dest.'" "'.$dest.'"';
        shell_exec($cmd);	
    }
    return True;
}
?>
<span class="page_title">Paramètres des illustrations</span>
    <table id="interfaceSettingsTable">
        <tr>
            <td>
                <?php
                    $tempFile = new tempSecureImage();
                    $my_avatar = $tempFile->createTempPic($data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "avatar"));
                ?>
                <img class="middle-avatar" id="middle-avatar-pic" src="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY'].'/'.$my_avatar; ?>" width="150px">
            </td>
            <td>
                <form method="POST" enctype="multipart/form-data" action="" id="profile-edit-picture">
                    <input type="file" name="picture" accept="image/*"><br /><br />
                        <?php
                            if(isset($_GET['rotate'])) {
                                shell_exec("convert ".$data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "avatar")." -rotate 90 ".$data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "avatar"));
                                shell_exec("convert ".$data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "small_avatar")." -rotate 90 ".$data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "small_avatar"));
                                sleep(1);
                                Header('Location: '.$_SESSION['NAAT_GOTO_URL'].'/settings?group=pictures&success_image_rotated#imageDeProfil');
                                Exit(); //optional
                                ?>
                                <?php
                            }
                            if(isset($_GET['success_image_rotated'])) {
                                ?>
                            <p class='success'>Image tournée de 90 degrès</p>
                            <br />
                                <?php
                            }
                        ?>
                        <a href="?group=pictures&rotate" onclick="dispLoadingIcon('Rotation de votre image ...');">Tourner l'image de 90°</a>
                        <br /><br />
                    <input type="submit" name="upload" value="Changer la photo" class="form_input_submit_login" onclick="dispLoadingIcon('Enregistrement de votre image ...');">
                </form>
                <br />
                <span class="small_indic">Les types de fichiers autorisés sont: png, jpeg, gif<br />La taille doit être inférieure ou égale à 12Mo</span>
            </td>
            <td>
                <?php
                    if(isset($_POST['upload'])) {

                        $content_dir = 'MNT_DB/'.$data_access->user_block($_SESSION['userName']).$data_access->user_path($_SESSION['userName']).'/';

                        $tmp_file = $_FILES['picture']['tmp_name'];

                        if(!is_uploaded_file($tmp_file)) {
                            echo "<p class='error'>Une erreur interne est survenue.</p><br />";
                        }
                        else{
                            $type_file = $_FILES['picture']['type'];

                            if(!@getimagesize($_FILES['picture']['tmp_name']) OR !strstr($type_file, 'jpg') && !strstr($type_file, 'jpeg') && !strstr($type_file, 'gif') && !strstr($type_file, 'png')) {
                                echo "<p class='error'>Ce fichier n'est pas une image.</p><br />";
                            }
                            else{
                                $name_file = uniqid().'.'.explode('/',$type_file)[1];

                                if(preg_match('#[\x00-\x1F\x7F-\x9F/\\\\]#', $name_file) ) {
                                    echo "<p class='error'>Fichier invalide.</p><br />";
                                }
                                else{

                                    if(!move_uploaded_file($tmp_file, $content_dir . $name_file)) {
                                        echo "<p class='error'>Une erreur est survenue.</p><br />";
                                    }
                                    else{
                                        if(darkroom('MNT_DB/'.$data_access->user_block($_SESSION['userName']).$data_access->user_path($_SESSION['userName']).'/'.$name_file, 'MNT_DB/'.$data_access->user_block($_SESSION['userName']).$data_access->user_path($_SESSION['userName']).'/small.'.$name_file, 200)) {
                                            $name = 'MNT_DB/'.$data_access->user_block($_SESSION['userName']).$data_access->user_path($_SESSION['userName']).'/'.$name_file;
                                            $name_small = 'MNT_DB/'.$data_access->user_block($_SESSION['userName']).$data_access->user_path($_SESSION['userName']).'/small.'.$name_file;
                                            $ancienAvatar = $data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "avatar");
                                            if($ancienAvatar != "media/pictures/avatar.png") {
                                                @unlink($ancienAvatar);
                                            }
                                            $db->query('INSERT INTO infos_history("NAME","VALUE","TIME","FROM_IP") VALUES("avatar","'.$db->escapeString($data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "avatar")).'","'.time().'","'.$_SERVER['REMOTE_ADDR'].'")');
                                            $db->query('INSERT INTO infos_history("NAME","VALUE","TIME","FROM_IP") VALUES("small_avatar","'.$db->escapeString($data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "small_avatar")).'","'.time().'","'.$_SERVER['REMOTE_ADDR'].'")');
                                            $data_access->set_($_SESSION['currentUserBlock'], $_SESSION['userName'], "avatar", $name, True);
                                            $data_access->set_($_SESSION['currentUserBlock'], $_SESSION['userName'], "small_avatar", $name_small, True);
                                            if($db->query('SELECT "VALUE" as ct FROM listing_infos WHERE "NAME" = "createPostForNewPic"')->fetchArray()['ct'] == 1) {
                                                $db->query('INSERT INTO listing_posts("DATE","TITLE","CONTENT","TYPE","FROM_IP","PRIVACY") VALUES("'.time().'","Nouvelle image de profil !","'.$name_small.'","NEW_PROFILE_PIC","'.$_SERVER['REMOTE_ADDR'].'","3")');
                                            }
                                            echo "<p class='success'>Image ajoutée !<br />Veuillez noter qu'il peut prendre jusqu'à plusieurs minutes pour que la photo soit changée sur l'ensemble du site.</p><br />";
                                            $_SESSION['currentUserAvatar'] = $name;
                                            $_SESSION['currentUserSmallAvatar'] = $name_small;
                                            $db->query('INSERT INTO listing_media("TITLE","CONTENT","TYPE","URL","PRIVACY") VALUES("Nouvelle image de profil","Ma nouvelle image de profil<br /><i>Publication automatique</i>","PIC","'.$name_small.'","1")');
                                            ?>
                                            <script type="text/javascript">
                                                document.getElementById("middle-avatar-pic").src = '<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']."/".$name; ?>';
                                            </script>
                                            <?php
                                        }else{
                                            echo "<p class='error'>Une erreur est survenue durant le redimensionnement.</p><br />";
                                        }
                                    }
                                }

                            }
                        }
                    }
                ?>
            </td>
        </tr>
<?php
    $images = array(
        'audience-backlit-band-154147.jpg',
        'architecture-australia-backlit-634010.jpg',
        'abstract-blue-concrete-34090.jpg',
        'pexels-photo-450035.jpeg',
        'nothing'
    );
    $images_ = array(
        'audience-backlit-band-154147.jpg' => 'Concert de nuit',
        'architecture-australia-backlit-634010.jpg' => 'Plage Australienne',
        'abstract-blue-concrete-34090.jpg' => 'Abstrait Bleu',
        'pexels-photo-450035.jpeg' => 'Ordinateurs Bureau',
        'nothing' => 'Sans image de fond'
    );
    if(isset($_GET['background']) AND in_array($_GET['background'], $images)) {
        if($data_access->set_($_SESSION['currentUserBlock'], $_SESSION['userName'], "background_image", $_GET['background'], True)) {
            $_SESSION['currentUserBackgroundImage'] = $_GET['background'];
            header("Location: ".$_SESSION['NAAT_GOTO_URL']."settings?group=pictures&success_update_backgound_image");
            Exit();
        }
        else{
            $message = "<p class='error'>Une erreur est survenue</p>";
        }
    }
    $currentBackground = $data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], 'background_image');
    if(isset($_GET['success_update_backgound_image'])) {
        $message = "<p class='success'>L'image est configurée!</p>";
    }
?>
        <tr>
            <td>
                <br />
                <?php if(isset($message)) { echo $message; } ?>
            </td>
            <td>
                <br />
                <span class="page_title">Changer l'image de fond de la page</span>
                <br /><br />
                <select name="background" class="settings-select" onchange="dispLoadingIcon('Enregistrement de l\'image'); window.location = '<?php echo $_SESSION['NAAT_GOTO_URL']; ?>settings?group=pictures&background=' + this.value;">
                <?php
                    if(!empty($currentBackground)) {
                        echo "<option value='".$currentBackground."'>Actuellement: ".$images_[$currentBackground]."</option>";
                    }
                    else{
                        echo "<option>Choisissez une image de fond</option>";
                    }
                    foreach($images_ as $key => $value) {
                        echo "<option value='".$key."'>".$value."</option>";
                    }
                ?>
                </select>
            </td>
            <td>
            </td>
        </tr>
    </table>