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
                Voici la liste des personnes que vous suivez
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
                                Il n'y a personne dans vos bulles
                            </p>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
    </div>
    <div class="clear"></div>
</div>