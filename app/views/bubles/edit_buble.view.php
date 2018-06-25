<?php
$data_access = new data_access();
$colors_lib = new giveColorFromEquivalent();
$db = new SQLite3('MNT_DB/'.$data_access->user_block($_SESSION['userName']).$data_access->user_path($_SESSION['userName']).'/data.db');
$db->busyTimeout(10000);

if(!isset($_GET['create']) AND isset($_GET['del_user']) AND !empty($_GET['del_user']) AND strlen($_GET['del_user']) < 50 AND ctype_alnum($_GET['del_user'])) {
    $del = htmlspecialchars($db->escapeString($_GET['del_user']));
    $id = htmlspecialchars($db->escapeString($_GET['buble_id']));
    $db->query('DELETE FROM listing_bubles_who WHERE "USERNAME" = "'.$del.'" AND "BUBLE_ID" = "'.$id.'"');
}
$id = htmlspecialchars($db->escapeString($_GET['buble_id']));
?>
<div id="page_content">

    <div class="row">
        <div class="col col-padding col-lg-10 col-sm-10">
            <p>
                <div class="pull_left">
                    <span class="page_title">Modifier une bulle</span>

                </div>
                <div class="pull_right" style="text-align: right;">
                    <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>edit_buble?create">Créer une bulle</a> &nbsp;&nbsp; <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>view_buble?buble_id=<?php echo $id; ?>">Ouvrir cette bulle</a>&nbsp;
                </div>
                <div class="clear"></div>
            </p>
        </div>
    </div>
    <div class="clear"></div>

    <div class="row">
    <?php
        $nbrInBuble = $db->query('SELECT count("ID") as ct_id FROM listing_bubles_who WHERE "BUBLE_ID" = "'.$id.'"')->fetchArray()['ct_id'];

        if(isset($_GET['del'])) {
            if($db->query('DELETE FROM listing_bubles WHERE "ID" = "'.$id.'"')) {
                sleep(1);
                Header('Location: '.$_SESSION['NAAT_GOTO_URL'].'dash?success_buble_deleted');
                Exit(); //optional
            }
            else{
                echo "<br /><p class='danger'>Echec</p><br />";
            }
        }
        
        $msg = array();
        if(isset($_POST['NAME']) AND !empty($_POST['NAME']) AND strlen($_POST['NAME']) < 1500) {
            $newName = $_POST['NAME'];
            if($db->query('UPDATE listing_bubles SET "NAME" = "'.$newName.'" WHERE "ID" = "'.$id.'"')) {
                $msg[] = "Nom modifié";
            }
        }
        if(isset($_POST['DESCRIPTION']) AND !empty($_POST['DESCRIPTION']) AND strlen($_POST['DESCRIPTION']) < 10001) {
            $newDescription = $_POST['DESCRIPTION'];
            if($db->query('UPDATE listing_bubles SET "DESCRIPTION" = "'.$newDescription.'" WHERE "ID" = "'.$id.'"')) {
                $msg[] = "Description modifiée";
            }
        }
        $colors = $colors_lib::giveColorsList();
        if(isset($_POST['BUBLE_COLOR']) AND !empty($_POST['BUBLE_COLOR']) AND in_array($_POST['BUBLE_COLOR'], $colors)) {
            $newColor = htmlspecialchars($db->escapeString($_POST['BUBLE_COLOR']));
            if($db->query('UPDATE listing_bubles SET "BUBLE_COLOR" = "'.$newColor.'" WHERE "ID" = "'.$id.'"')) {
                $msg[] = "Couleur modifiée";
            }
        }

        $results = $db->query('SELECT * FROM listing_bubles WHERE "ID" = "'.$id.'"');
        $count_bubles = 0;

        while($row = $results->fetchArray()) {
            ?>
            <div class="col col-padding col-sm-10 col-lg-10">
                <form method="POST" action="">
                    <span class="small_indic">Informations générales</span>
                    <?php
                        if(!empty($msg)) {
                            echo "<br /><br />";
                            foreach($msg as $key => $value) {
                                echo "<p class='success'><img src='".$_SESSION['NAAT_ORIGIN_DIRECTORY']."/inc/template/icons/svg/success.svg' width='35px' style='vertical-align:middle;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$value."</p>";
                            }
                            echo "<br /><br />";
                        }
                    ?>
                    <div class="row">
                        <div class="col col-padding col-lg-2">
                            <div class="small-rounded-avatar" style="background-color: <?php echo $colors_lib::giveFromName($row['BUBLE_COLOR']); ?>;" id="small_avatar_buble"><?php echo substr(htmlspecialchars_decode($row['NAME']), 0, 2); ?></div>
                        </div>
                        <div class="col col-padding col-lg-8">
                            <input type="text" name="NAME" class="input-full" value="<?php echo $row['NAME']; ?>" placeholder="Nom de la bulle">
                            <br />
                            <textarea name="DESCRIPTION" rows="5" class="input-full" placeholder="Description de la bulle" id="textareaPost" onkeyup="countChars();"><?php echo $row['DESCRIPTION']; ?></textarea>
                            <br />
                            <div class="pull_left">
                                <span class="small_indic" id="indicChars">0 caractère</span>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <select name="BUBLE_COLOR" class="settings-select" onchange="previewColor(this.value);">
                                    <option name="<?php echo $row['BUBLE_COLOR']; ?>"><?php echo $colors_lib::giveColors()[$row['BUBLE_COLOR']]; ?></option>
                                    <?php
                                    foreach($colors_lib::giveColors() as $key => $value) {
                                        ?>
                                        <option value="<?php echo $key; ?>" style="color: #FFF; background-color: <?php echo $colors_lib::giveFromName($key); ?>;"><?php echo $value; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="pull_right">
                                <input type="submit" name="edit-<?php echo $row['ID']; ?>" value="Modifier" class="form_input_submit_login" style="background-color: <?php echo $colors_lib::giveFromName($row['BUBLE_COLOR']); ?>;" id="submit_btn" onclick="dispLoadingIcon('Modification de votre bulle ...');">
                            </div>
                            <div style="clear: both;"></div>
                            <br />
                            <span class="small_indic">Options</span>&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>/edit_buble?buble_id=<?php echo $id; ?>&del" class="suppr_post small_indic" onclick="dispLoadingIcon('Suppression de la bulle ...');">Supprimer&nbsp;&nbsp;<img class="icon" src="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/icons/svg/error.svg" /></a>
                            <br /><br />
                            <span class="small_indic">Cette bulle a été créée le <?php echo date("d/m/Y", $row['CTIME']); ?></span>
                        </div>
                    </div>
                    <div style="clear: both;"></div>
                </form>
            </div>
            <!--<div class="col col-padding col-lg-10 div-colors-preview-all" id="div-colors-preview-all" style="display: none;">
                <div id="div-colors-preview">
                        <?php
                        foreach($colors_lib::giveColors() as $key => $value) {
                            ?>
                            <div class="" style="background-color: <?php echo $colors_lib::giveFromName($key); ?>;">
                                <?php echo $value; ?>
                            </div>
                            <?php
                        }
                        ?>
                </div>
            </div>-->
            <div class="col col-padding col-lg-10">
                <span class="page_title">Membres de cette bulle (<?php echo $nbrInBuble; ?>)</span>
                <br /><br />
                <table style="width: 100%;">
                    <?php
                        if($nbrInBuble > 0) {
                            $results_ = $db->query('SELECT * FROM listing_bubles_who WHERE "BUBLE_ID" = "'.$id.'" ORDER BY "ADD_TIME" DESC');
                            while($row_ = $results_->fetchArray()) {
                                ?>
                                <tr>
                                    <td style="vertical-align: baseline;">
                                        <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>profile?profile_id=<?php echo $row_['USERNAME']; ?>">@<?php echo $row_['USERNAME']; ?></a>
                                    </td>
                                    <td style="vertical-align: baseline;">
                                        <span class="small_indic"><?php echo $data_access->get_($data_access->user_block($row_['USERNAME']), $row_['USERNAME'], "nom_reel"); ?></span>
                                    </td>
                                    <td style="text-align: right;">
                                        <a href="?buble_id=<?php echo $id; ?>&del_user=<?php echo $row_['USERNAME']; ?>" class="suppr_post">Supprimer</a>
                                        <br /><br />
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                    }
                    ?>
                </table>
            </div>
    </div>
</div>

<script type="text/javascript">
    function previewColor(color) {
        var colors = new Array();
        <?php
        foreach($colors_lib::giveColorsFromName() as $key => $value) {
            ?>
            colors['<?php echo $key ?>'] = "<?php echo $value; ?>";
            <?php
        }
        ?>
        var color_ = colors[color];
        document.getElementById("submit_btn").style = "background-color: " + color_ + ";";
        document.getElementById("small_avatar_buble").style = "background-color: " + color_ + ";";
    }

    var nbrCharMaxInTextarea = 10000;
    var indicChars = document.getElementById("indicChars");

    function countChars() {
        var strInTextarea = document.getElementById("textareaPost").value;
        var nbrChars = strInTextarea.length;
        if(nbrChars > nbrCharMaxInTextarea) { 
            indicChars.style = "color: #F00;";
        }
        else{
            indicChars.style = "";
        }
        if(nbrChars > 1) {
            var s = "s";
        }
        else{
            var s = "";
        }
        indicChars.innerHTML = nbrChars + "/" + nbrCharMaxInTextarea;
    }
</script>