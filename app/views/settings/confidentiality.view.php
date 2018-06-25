<div class="row">
    <div class="col col-padding col-lg-10 col-sm-10">
        <span class="page_title">Paramètres de confidentialité</span>
        <br /><br />
        <table class="table-confidential-settings">
            <tr>
                <td>
                    <span class="small_indic">Dernière fois en ligne</span>
                </td>
                <td>
                    <p class="small_indic">
                    Actuellement:
                    <?php
                        $visibilityOnline = $db->query('SELECT "VALUE" as ct FROM listing_infos WHERE "NAME" = "confidentialVisibleOnline"')->fetchArray()['ct'];
                        if(isset($_GET['changeVisibilityOnline'])) {
                            if($visibilityOnline == "1") {
                                $db->query('UPDATE listing_infos SET "VALUE" = "0" WHERE "NAME" = "confidentialVisibleOnline"');
                            }
                            if($visibilityOnline == "0") {
                                $db->query('UPDATE listing_infos SET "VALUE" = "1" WHERE "NAME" = "confidentialVisibleOnline"');
                            }
                            sleep(1);
                            Header('Location: '.$_SESSION['NAAT_GOTO_URL'].'settings?group=confidentiality');
                            Exit(); //optional
                        }
                        if($visibilityOnline == "0") {
                            ?>
                            <br />
                            masquée
                            <?php
                        }
                        else{
                            ?>
                            <br />
                            visible
                            <?php
                        }
                    ?>
                    </p>
                </td>
                <td>
                    <?php
                        if($visibilityOnline == "0") {
                            ?>
                            <p class="small_indic"><a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>settings?group=confidentiality&changeVisibilityOnline" onclick="dispLoadingIcon('Enregistrement de vos préférences ...');">Afficher</a></p>
                            <?php
                        }
                        else{
                            ?>
                            <p class="small_indic"><a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>settings?group=confidentiality&changeVisibilityOnline" onclick="dispLoadingIcon('Enregistrement de vos préférences ...');">Masquer</a></p>
                            <?php
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    <br />
                </td>
                <td>
                    <br />
                </td>
                <td>
                    <br />
                </td>
            </tr>
            <tr>
                <td>
                    <span class="small_indic">Adresse email sur le profil</span>
                </td>
                <td>
                    <p class="small_indic">
                    Actuellement:
                    <?php
                        $visibilityEmail = $db->query('SELECT "VALUE" as ct FROM listing_infos WHERE "NAME" = "confidentialVisibleEmail"')->fetchArray()['ct'];
                        if(isset($_GET['changeVisibilityEmail'])) {
                            if($visibilityEmail == "1") {
                                $db->query('UPDATE listing_infos SET "VALUE" = "0" WHERE "NAME" = "confidentialVisibleEmail"');
                            }
                            if($visibilityEmail == "0") {
                                $db->query('UPDATE listing_infos SET "VALUE" = "1" WHERE "NAME" = "confidentialVisibleEmail"');
                            }
                            sleep(1);
                            Header('Location: '.$_SESSION['NAAT_GOTO_URL'].'settings?group=confidentiality');
                            Exit(); //optional
                        }
                        if($visibilityEmail == "0") {
                            ?>
                            <br />
                            masquée
                            <?php
                        }
                        else{
                            ?>
                            <br />
                            visible
                            <?php
                        }
                    ?>
                    </p>
                </td>
                <td>
                    <?php
                        if($visibilityEmail == "0") {
                            ?>
                            <p class="small_indic"><a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>settings?group=confidentiality&changeVisibilityEmail" onclick="dispLoadingIcon('Enregistrement de vos préférences ...');">Afficher</a></p>
                            <?php
                        }
                        else{
                            ?>
                            <p class="small_indic"><a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>settings?group=confidentiality&changeVisibilityEmail" onclick="dispLoadingIcon('Enregistrement de vos préférences ...');">Masquer</a></p>
                            <?php
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    <br />
                </td>
                <td>
                    <br />
                </td>
                <td>
                    <br />
                </td>
            </tr>
            <tr>
                <td>
                    <span class="small_indic">Message vu</span>
                </td>
                <td>
                    <p class="small_indic">
                    Actuellement:
                    <?php
                        $visibilitySeen = $db->query('SELECT "VALUE" as ct FROM listing_infos WHERE "NAME" = "confidentialVisibleSeen"')->fetchArray()['ct'];
                        if(isset($_GET['changeVisibilitySeen'])) {
                            if($visibilitySeen == "1") {
                                $db->query('UPDATE listing_infos SET "VALUE" = "0" WHERE "NAME" = "confidentialVisibleSeen"');
                            }
                            if($visibilitySeen == "0") {
                                $db->query('UPDATE listing_infos SET "VALUE" = "1" WHERE "NAME" = "confidentialVisibleSeen"');
                            }
                            sleep(1);
                            Header('Location: '.$_SESSION['NAAT_GOTO_URL'].'settings?group=confidentiality');
                            Exit(); //optional
                        }
                        if($visibilitySeen == "0") {
                            ?>
                            <br />
                            masqué
                            <?php
                        }
                        else{
                            ?>
                            <br />
                            visible
                            <?php
                        }
                    ?>
                    </p>
                </td>
                <td>
                    <?php
                        if($visibilitySeen == "0") {
                            ?>
                            <p class="small_indic"><a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>settings?group=confidentiality&changeVisibilitySeen" onclick="dispLoadingIcon('Enregistrement de vos préférences ...');">Afficher</a></p>
                            <?php
                        }
                        else{
                            ?>
                            <p class="small_indic"><a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>settings?group=confidentiality&changeVisibilitySeen" onclick="dispLoadingIcon('Enregistrement de vos préférences ...');">Masquer</a></p>
                            <?php
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    <br />
                </td>
                <td>
                    <br />
                </td>
                <td>
                    <br />
                </td>
            </tr>
            <tr>
                <td>
                    <span class="small_indic">Mes posts</span>
                    <br />
                    <span class="small_indic">(Privés = visibles par les personnes que j'ai mis dans mes bulles uniquement)</span>
                </td>
                <td>
                    <p class="small_indic">
                    Actuellement:
                    <?php
                        $visibilityPosts = $db->query('SELECT "VALUE" as ct FROM listing_infos WHERE "NAME" = "confidentialVisiblePosts"')->fetchArray()['ct'];
                        if(isset($_GET['changeVisibilityPosts'])) {
                            if($visibilityPosts == "1") {
                                $db->query('UPDATE listing_infos SET "VALUE" = "0" WHERE "NAME" = "confidentialVisiblePosts"');
                            }
                            if($visibilityPosts == "0") {
                                $db->query('UPDATE listing_infos SET "VALUE" = "1" WHERE "NAME" = "confidentialVisiblePosts"');
                            }
                            sleep(1);
                            Header('Location: '.$_SESSION['NAAT_GOTO_URL'].'settings?group=confidentiality');
                            Exit(); //optional
                        }
                        if($visibilityPosts == "0") {
                            ?>
                            <br />
                            privés
                            <?php
                        }
                        else{
                            ?>
                            <br />
                            visibles par tous
                            <?php
                        }
                    ?>
                    </p>
                </td>
                <td>
                    <?php
                        if($visibilityPosts == "0") {
                            ?>
                            <p class="small_indic"><a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>settings?group=confidentiality&changeVisibilityPosts" onclick="dispLoadingIcon('Enregistrement de vos préférences ...');">Afficher</a></p>
                            <?php
                        }
                        else{
                            ?>
                            <p class="small_indic"><a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>settings?group=confidentiality&changeVisibilityPosts" onclick="dispLoadingIcon('Enregistrement de vos préférences ...');">Masquer</a></p>
                            <?php
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    <br />
                </td>
                <td>
                    <br />
                </td>
                <td>
                    <br />
                </td>
            </tr>
            <tr>
                <td>
                    <span class="small_indic">Ma biographie</span>
                    <br />
                    <span class="small_indic">(Privés = visibles par les personnes que j'ai mis dans mes bulles uniquement)</span>
                </td>
                <td>
                    <p class="small_indic">
                    Actuellement:
                    <?php
                        $visibilityBio = $db->query('SELECT "VALUE" as ct FROM listing_infos WHERE "NAME" = "confidentialVisibleBio"')->fetchArray()['ct'];
                        if(isset($_GET['changeVisibilityBio'])) {
                            if($visibilityBio == "1") {
                                $db->query('UPDATE listing_infos SET "VALUE" = "0" WHERE "NAME" = "confidentialVisibleBio"');
                            }
                            if($visibilityBio == "0") {
                                $db->query('UPDATE listing_infos SET "VALUE" = "1" WHERE "NAME" = "confidentialVisibleBio"');
                            }
                            sleep(1);
                            Header('Location: '.$_SESSION['NAAT_GOTO_URL'].'settings?group=confidentiality');
                            Exit(); //optional
                        }
                        if($visibilityBio == "0") {
                            ?>
                            <br />
                            privée
                            <?php
                        }
                        else{
                            ?>
                            <br />
                            visible par tous
                            <?php
                        }
                    ?>
                    </p>
                </td>
                <td>
                    <?php
                        if($visibilityBio == "0") {
                            ?>
                            <p class="small_indic"><a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>settings?group=confidentiality&changeVisibilityBio" onclick="dispLoadingIcon('Enregistrement de vos préférences ...');">Afficher</a></p>
                            <?php
                        }
                        else{
                            ?>
                            <p class="small_indic"><a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>settings?group=confidentiality&changeVisibilityBio" onclick="dispLoadingIcon('Enregistrement de vos préférences ...');">Masquer</a></p>
                            <?php
                        }
                    ?>
                </td>
            </tr>
        </table>
    </div>

    <div class="col col-padding col-lg-10 col-sm-10">
        <span class="title">Mes posts sont visibles par:</span>
        <br /><br />
        <?php
            if($visibilityPosts == "1") {
                ?>
                <p class="small_indic">
                    Tout le monde ayant un compte
                </p>
                <?php
            }
            else{
                ?>
                <p class="small_indic">
                    Les personnes que vous avez ajoutées à vos bulles peuvent les voir
                </p>
                <br />
                <table style="width: 100%;">
                    <?php
                    $listPersonsAllowed = $db->query('SELECT DISTINCT "USERNAME" FROM "listing_bubles_who"');
                    $nbr = 0;
                    while($row = $listPersonsAllowed->fetchArray()) {
                        $nbr++;
                        ?>
                        <tr>
                            <td>

                            </td>
                            <td>
                                <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>profile?profile_id=<?php echo $row['USERNAME']; ?>"><span class="small_indic">@<?php echo $row["USERNAME"]; ?></span></a>
                            </td>
                            <td>
                                <span class="small_indic"><?php echo $data_access->get_($_SESSION['currentUserBlock'], $row['USERNAME'], "nom_reel"); ?></span>
                            </td>
                        </tr>
                        <?php
                    }
                    if($nbr == 0) {
                        ?>
                        <tr>
                            <td>
                                <p class="error">
                                    Il n'y a personne dans vos bulles donc personne ne peut voir vos posts actuellement
                                </p>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
                <?php
            }
        ?>
    </div>

    <div class="col col-padding col-lg-5 col-sm-10">
        <span class="title">Ma biographie est visible par:</span>
        <br /><br />
        <?php
            if($visibilityBio == "1") {
                ?>
                <p class="small_indic">
                    Tout le monde ayant un compte
                </p>
                <?php
            }
            else{
                ?>
                <p class="small_indic">
                    Les personnes que vous avez ajoutées à vos bulles peuvent les voir
                </p>
                <br />
                <table style="width: 100%;">
                    <?php
                    $listPersonsAllowed = $db->query('SELECT DISTINCT "USERNAME" FROM "listing_bubles_who"');
                    $nbr = 0;
                    while($row = $listPersonsAllowed->fetchArray()) {
                        $nbr++;
                        ?>
                        <tr>
                            <td>

                            </td>
                            <td>
                                <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>profile?profile_id=<?php echo $row['USERNAME']; ?>"><span class="small_indic">@<?php echo $row["USERNAME"]; ?></span></a>
                            </td>
                            <td>
                                <span class="small_indic"><?php echo $data_access->get_($_SESSION['currentUserBlock'], $row['USERNAME'], "nom_reel"); ?></span>
                            </td>
                        </tr>
                        <?php
                    }
                    if($nbr == 0) {
                        ?>
                        <tr>
                            <td>
                                <p class="error">
                                    Il n'y a personne dans vos bulles donc personne ne peut voir votre biographie actuellement
                                </p>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
                <?php
            }
        ?>
    </div>
</div>