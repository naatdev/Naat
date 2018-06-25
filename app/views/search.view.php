<?php
$data_access = new data_access();
$colors_lib = new giveColorFromEquivalent();
$db = new SQLite3('MNT_DB/'.$data_access->user_block($_SESSION['userName']).$data_access->user_path($_SESSION['userName']).'/data.db');
$db->busyTimeout(10000);
if(isset($_POST['search_str']) AND !empty($_POST['search_str']) AND strlen($_POST['search_str']) < 20 AND ctype_alnum($_POST['search_str'])) {
	$searchStr = htmlspecialchars($_POST['search_str']);
}
?>
<div id="page_content">
    <div class="row">
        <div class="col col-padding col-lg-10 col-sm-10">
            <span class="page_title">Résultats de recherche</span>
            <br /><br />
            <span class="small_indic">Vous pouvez rechercher un membre par son identifiant.</span>

            <div class="col col-padding col-sm-10 col-lg-10">
                <form method="POST" action="">
                    <input type="text" name="search_str" class="input_full" placeholder="Recherche par identifiant ..." value="<?php if(isset($searchStr)) {echo $searchStr;} ?>">
                    <button type="submit" class="button-icon" name="search"><i class="fa fa-search"></i> &nbsp;&nbsp;rechercher</button>
                </form>
            </div>
            
            <?php
            if(isset($_POST['search_str']) AND (strlen($_POST['search_str']) > 19 OR strlen($_POST['search_str']) < 1 OR !ctype_alnum($_POST['search_str']))) {
                ?>
                <div class="col col-sm-10 col-lg-10">
                    <br />
                        <p class="error">Veuillez entrer une chaine de caractéres composée d'au moins 1 et de moins de 20 caractères et de chiffres et lettres uniquement.</p>
                    <br />
                </div>
                <?php
                $validSearch = False;
            }
            if(isset($searchStr) AND !isset($validSearch)) {
                $count = 0;
                $db = new SQLite3('MNT_DB/userlist.db');
                $db->busyTimeout(10000);
                $searchStr_ = htmlspecialchars($db->escapeString($searchStr));
                $results = $db->query('SELECT * FROM USERS WHERE "USERNAME" LIKE "%'.$searchStr_.'%" ORDER BY "ID" DESC LIMIT 20');

                while($row = $results->fetchArray()) {
                    $count++;
                    ?>
                    <div class="row">
                        <div class="col col-padding col-sm-10 col-lg-10">
                            <table>
                                <tr>
                                    <td>
                                    <div class="small_avatar_me" style="background-image:url('<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY'].'/'.$data_access->get_($data_access->user_block($row['USERNAME']), $row['USERNAME'], "small_avatar"); ?>');"></div>
                                    </td>
                                    <td style="padding-left: 15px;">
                                        <span class="small_indic"><?php echo $data_access->get_("infos", $row['USERNAME'], "nom_reel"); ?></span>
                                        <br />
                                        &nbsp;&nbsp;<a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>profile?profile_id=<?php echo $row['USERNAME']; ?>">@<?php echo $row['USERNAME']; ?></a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <?php
                }
                ?>
                    <div class="col col-sm-10 col-lg-10">
                        <?php if($count > 0) { ?>
                        <!--<p class="success">Fin des résultats</p>-->
                        <?php }else{ ?>
                        <p class="error">Aucun résultat pour le terme '<?php echo $searchStr_; ?>'</p>
                        <?php } ?>
                    </div>
                <?php
            }
            ?>
            <div class="col col-padding col-sm-10 col-lg-10">
                <p class="info">Seuls les 20 premiers résultats sont affichés.</p>
            </div>

        </div><!-- /col -->
    </div><!-- /row -->
</div><!-- /page_content -->