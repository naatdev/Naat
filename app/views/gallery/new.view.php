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
$data_access = new data_access();
$colors_lib = new giveColorFromEquivalent();
$db = new SQLite3('MNT_DB/'.$data_access->user_block($_SESSION['userName']).$data_access->user_path($_SESSION['userName']).'/data.db');
$db->busyTimeout(10000);
?>
<div id="page_content">
    <div class="row">
        <div class="col col-padding col-lg-10">
            <h1 class="page_title">Ajouter une image à la galerie</h1>
        </div>
        <div class="col col-padding col-lg-10">
            <?php
                if(isset($_GET['success'])) {
                    echo "<p class='success'>Image ajoutée !<br />Veuillez noter qu'il peut prendre jusqu'à plusieurs minutes pour que la photo apparaisse sur l'ensemble du site.</p><br />";
                }
                if(isset($_SESSION['pause_upload_5min'])) {
                    if($_SESSION['pause_upload_5min'] <= (time()-60)) {
                        unset($_SESSION['pause_upload_5min']);
                    }
                }
                if(isset($_SESSION['pause_upload_5min'])) {
                    echo "<p class='error'>Vous avez mis en ligne une photo il y a moins de 1min, veuillez patientez 1min entre chaque envoi ! Si vous tentez d'uploader une photo cela ne fonctionnera pas.</p><br /><br />";
                }
            ?>
            <form method="POST" enctype="multipart/form-data" action="" id="gallery-add-picture">
                <input type="text" name="title" value="<?php if(isset($_POST['title']) AND !empty($_POST['title'])) {echo $_POST['title'];} ?>" placeholder="Titre de l'image" onfocus="dispSomeHelp('La taille ne peut excéder 1000 caractères pour ce champ texte !');" />
                <textarea name="description" placeholder="Description de l'image" rows="4" onfocus="dispSomeHelp('La taille ne peut excéder 10000 caractères pour ce champ texte !');"><?php if(isset($_POST['description']) AND !empty($_POST['description'])) {echo $_POST['description'];} ?></textarea>
                <input type="file" name="picture" accept="image/*"><br /><br />
                <input type="submit" name="upload" value="Mettre en ligne la photo" class="form_input_submit_login" onclick="dispLoadingIcon('Enregistrement de votre image ...');">
            </form>
        </div>
        <?php
            if(isset($_POST['upload']) AND isset($_POST['title']) AND isset($_POST['description']) AND (!isset($_SESSION['pause_upload_5min']) OR $_SESSION['pause_upload_5min'] <= (time()-60)) AND strlen($_POST['title'] < 1001) AND strlen($_POST['description'] < 10001)) {
                echo '<div class="col col-padding col-lg-10 col-text-align-center">';

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
                        $name_file = 'pic-'.uniqid().'.'.explode('/',$type_file)[1];

                        if(preg_match('#[\x00-\x1F\x7F-\x9F/\\\\]#', $name_file) ) {
                            echo "<p class='error'>Fichier invalide.</p><br />";
                        }
                        else{

                            if(!move_uploaded_file($tmp_file, $content_dir . $name_file)) {
                                echo "<p class='error'>Une erreur est survenue.</p><br />";
                            }
                            else{
                                if(darkroom('MNT_DB/'.$data_access->user_block($_SESSION['userName']).$data_access->user_path($_SESSION['userName']).'/'.$name_file, 'MNT_DB/'.$data_access->user_block($_SESSION['userName']).$data_access->user_path($_SESSION['userName']).'/small.'.$name_file, 600)) {
                                    $title = $_POST['title'];
                                    $content = $_POST['description'];
                                    $name = 'MNT_DB/'.$data_access->user_block($_SESSION['userName']).$data_access->user_path($_SESSION['userName']).'/'.$name_file;
                                    $name_small = 'MNT_DB/'.$data_access->user_block($_SESSION['userName']).$data_access->user_path($_SESSION['userName']).'/small.'.$name_file;
                                    $db->query('INSERT INTO listing_media("TITLE","CONTENT","TYPE","URL","PRIVACY") VALUES("'.$title.'","'.$content.'","PIC","'.$name_small.'","1")');
                                    $_SESSION['pause_upload_5min'] = time();
                                    Header("Location: ".$_SESSION['NAAT_GOTO_URL']."pic_add?success");
                                    exit();
                                }else{
                                    echo "<p class='error'>Une erreur est survenue durant le redimensionnement.</p><br />";
                                }
                            }
                        }

                    }
                }
                echo '</div>';
            }
        ?>
    </div>
    <div class="clear"></div>
</div>