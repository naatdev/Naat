<span class="page_title">Paramètres des publications</span>

<table id="interfaceSettingsTable">
    <tr>
        <td>
            <br /><span>Création de publications</span>
        </td>
        <td>
            <span class="small_indic">
                <?php
                    $createPostForNewPic = $db->query('SELECT "VALUE" as ct FROM listing_infos WHERE "NAME" = "createPostForNewPic"')->fetchArray()['ct'];
                    if(isset($_GET['changePostForNewPic'])) {
                        if($createPostForNewPic == "1") {
                            $db->query('UPDATE listing_infos SET "VALUE" = "0" WHERE "NAME" = "createPostForNewPic"');
                        }
                        if($createPostForNewPic == "0") {
                            $db->query('UPDATE listing_infos SET "VALUE" = "1" WHERE "NAME" = "createPostForNewPic"');
                        }
                        sleep(1);
                        Header('Location: '.$_SESSION['NAAT_GOTO_URL'].'settings?group=posts&success_post_new_pic');
                        Exit(); //optional
                    }
                    if($createPostForNewPic == "0") {
                        ?>
                        Aucun post n'est publié à chaque changement de photo de profil<br />
                        <?php
                    }
                    else{
                        ?>
                        Une publication est créée lorsque vous changez de photo de profil<br />
                        <?php
                    }
                    if($createPostForNewPic == "0") {
                        ?>
                        <br />
                        <p class="small_indic"><a href="?group=posts&changePostForNewPic" onclick="dispLoadingIcon('Enregistrement de vos préférences ...');">Créer un post</a></p>
                        <br />
                        <?php
                    }
                    else{
                        ?>
                        <br />
                        <p class="small_indic"><a href="?group=posts&changePostForNewPic" onclick="dispLoadingIcon('Enregistrement de vos préférences ...');">Ne pas en créer</a></p>
                        <br />
                        <?php
                    }
                ?>
            </span>
        </td>
        <td>
            <?php
                 if($createPostForNewPic == "0") {
                    ?>
                    <a href="?group=posts&changePostForNewPic" onclick="dispLoadingIcon('Enregistrement de vos préférences ...');"><img src="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/icons/svg/switch-2.svg" width="55px" onclick="this.src='<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/icons/svg/switch-3.svg';" /></a>
                    <?php
                }
                else{
                    ?>
                    <a href="?group=posts&changePostForNewPic" onclick="dispLoadingIcon('Enregistrement de vos préférences ...');"><img src="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/icons/svg/switch-3.svg" width="55px" onclick="this.src='<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/icons/svg/switch-2.svg';" /></a>
                    <?php
                }
            ?>
        </td>
    </tr>
    <tr>
        <td>
            
        </td>
        <td>
            <span class="small_indic">
                <?php
                    $createPostForNewBio = $db->query('SELECT "VALUE" as ct FROM listing_infos WHERE "NAME" = "createPostForNewBio"')->fetchArray()['ct'];
                    if(isset($_GET['changePostForNewBio'])) {
                        if($createPostForNewBio == "1") {
                            $db->query('UPDATE listing_infos SET "VALUE" = "0" WHERE "NAME" = "createPostForNewBio"');
                        }
                        if($createPostForNewBio == "0") {
                            $db->query('UPDATE listing_infos SET "VALUE" = "1" WHERE "NAME" = "createPostForNewBio"');
                        }
                        sleep(1);
                        Header('Location: '.$_SESSION['NAAT_GOTO_URL'].'settings?group=posts&success_post_new_bio');
                        Exit(); //optional
                    }
                    if($createPostForNewBio == "0") {
                        ?>
                        Aucun post n'est publié à chaque mise à jour de votre biographie<br />
                        <?php
                    }
                    else{
                        ?>
                        Une publication est créée lorsque vous mettez à jour votre biographie<br />
                        <?php
                    }
                    if($createPostForNewBio == "0") {
                        ?>
                        <br />
                        <p class="small_indic"><a href="?group=posts&changePostForNewBio" onclick="dispLoadingIcon('Enregistrement de vos préférences ...');">Créer un post</a></p>
                        <br />
                        <?php
                    }
                    else{
                        ?>
                        <br />
                        <p class="small_indic"><a href="?group=posts&changePostForNewBio" onclick="dispLoadingIcon('Enregistrement de vos préférences ...');">Ne pas en créer</a></p>
                        <br />
                        <?php
                    }
                ?>
            </span>
        </td>
        <td>
            <?php
                 if($createPostForNewBio == "0") {
                    ?>
                    <a href="?group=posts&changePostForNewBio" onclick="dispLoadingIcon('Enregistrement de vos préférences ...');"><img src="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/icons/svg/switch-2.svg" width="55px" onclick="this.src='<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/icons/svg/switch-3.svg';" /></a>
                    <?php
                }
                else{
                    ?>
                    <a href="?group=posts&changePostForNewBio" onclick="dispLoadingIcon('Enregistrement de vos préférences ...');"><img src="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/icons/svg/switch-3.svg" onclick="this.src='<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/icons/svg/switch-2.svg';" width="55px" /></a>
                    <?php
                }
            ?>
        </td>
    </tr>
<?php
$bublesIds = array();
$bubleForDash = $data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], 'currentUserBubleOnDash');
?>
    <tr>
        <td>
            <span>Bulle à afficher sur la page d'accueil</span>
        </td>
        <td>
            <select name="bubleDash" class="settings-select" onchange="dispLoadingIcon('Enregistrement de la bulle'); window.location = '<?php echo $_SESSION['NAAT_GOTO_URL']; ?>settings?group=posts&buble=' + this.value;">
                <?php
                    if(empty($bubleForDash) AND is_null($bubleForDash)) {
                        echo "<option value=\"none\">Sélectionner une bulle</option>";
                    }
                    else{
                        if($db->query('SELECT count("ID") as ct_id FROM listing_bubles WHERE "ID" = "'.$bubleForDash.'"')->fetchArray()['ct_id'] > 0) {
                            echo "<option value=\"".$bubleForDash."\">Actuellement: ".$db->query('SELECT NAME FROM listing_bubles WHERE "ID" = "'.$bubleForDash.'"')->fetchArray()['NAME']."</option>";
                        }
                        else{
                            echo "<option value=\"none\">Sélectionner une bulle</option>";
                        }
                    }
                    $listBubles = $db->query('SELECT ID,NAME FROM listing_bubles');
                    while($row = $listBubles->fetchArray()) {
                        $bublesIds[] = $row['ID'];
                        ?>
                    <option value="<?php echo $row['ID']; ?>"><?php echo $row['NAME']; ?></option>
                        <?php
                    }
                ?>
            </select>
        </td>
        <td>
            <?php
                if(isset($_GET['buble']) AND is_numeric($_GET['buble'])) {
                    if(in_array($_GET['buble'], $bublesIds)) {
                        if($data_access->set_($_SESSION['currentUserBlock'], $_SESSION['userName'], 'currentUserBubleOnDash', $_GET['buble'], True)) {
                            Header("Location: ".$_SESSION['NAAT_GOTO_URL']."settings?group=posts&success_buble_dash");
                            Exit();
                        }
                    }
                }
                if(isset($_GET['success_buble_dash'])) {
                    echo "<span class=\"success\">Préférence enregistrée</span>";
                }
            ?>
        </td>
    </tr>
</table>