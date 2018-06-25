<div id="page_content_mails">
    <?php
    $data_access = new data_access();
    $tempSecureImage = new tempSecureImage();
    $emojis = new emojis();
    $db = new SQLite3('MNT_DB/'.$data_access->user_block($_SESSION['userName']).$data_access->user_path($_SESSION['userName']).'/data.db');
    $db->busyTimeout(10000);

    if(isset($_GET['mark_all_as_read'])) {
        $db->query('UPDATE listing_messages SET "SEEN" = "1" WHERE "TO" = "'.$_SESSION['userName'].'"');
    }

    $unreadMsg = $db->query('SELECT count("ID") as ct_id FROM listing_messages WHERE "SEEN" = "0" AND "FROM" != "'.$_SESSION['userName'].'" AND "ARCHIVED" != "1"')->fetchArray()['ct_id'];
    $unreadMsgS = $unreadMsg > 1 ? "s" : "";
    ?>

    <div class="row">
        <div class="col col-padding col-lg-10 col-sm-10">
            <span class="page_title">Messages <?php echo isset($_GET['sent']) ? "envoyés" : "reçus"; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;<span class='badge_count'><?php echo $unreadMsg; ?></span>&nbsp;<span class='small_indic'>message<?php echo $unreadMsgS; ?> non lu<?php echo $unreadMsgS; ?></span>
            <br />
            <?php
            if(isset($_GET['success_del'])) {
                ?>
                <p class="success">Message supprimé</p>
                <br />
                <?php
            }
            ?>
        </div>
    </div>
    <div class="clear"></div>

    <?php
    if(isset($_GET['sent'])) {
        $sqlTerm = "=";
    }
    else{
        $sqlTerm = "!=";
    }
    if(!isset($_GET['DATE']) OR empty($_GET['DATE']) OR !is_numeric($_GET['DATE'])) {
        $results_ct = $db->query('SELECT count("ID") as ct_id FROM listing_messages WHERE "FROM" '.$sqlTerm.' "'.$_SESSION['userName'].'" AND "ARCHIVED" != "1"')->fetchArray()['ct_id'];
        $results = $db->query('SELECT * FROM listing_messages WHERE "FROM" '.$sqlTerm.' "'.$_SESSION['userName'].'" AND "ARCHIVED" != "1" ORDER BY "ID" DESC LIMIT 20');
    }
    else{
        $results = $db->query('SELECT * FROM listing_messages WHERE "FROM" '.$sqlTerm.' "'.$_SESSION['userName'].'" AND "DATE" < "'.$db->escapeString($_GET['DATE']).'" AND "ARCHIVED" != "1" ORDER BY "ID" DESC LIMIT 20');
        $results_ct = $db->query('SELECT count("ID") as ct_id FROM listing_messages WHERE "FROM" '.$sqlTerm.' "'.$_SESSION['userName'].'" AND "DATE" < "'.$db->escapeString($_GET['DATE']).'" AND "ARCHIVED" != "1"')->fetchArray()['ct_id'];
        ?>
            <div class="row">
                <div class="col col-padding col-small-bordered-top col-sm-10 col-lg-10">
                    <center><span class="info">messages d'avant le <?php echo date("d/m/Y à H:i", $_GET['DATE']); ?></span></center>
                </div>
            </div>
            <div class="clear"></div>
        <?php
    }
    ?>
    <table id="listConvMessages">
    <?php
    $saveAvatars = array();
    while($row = $results->fetchArray()) {
        if(isset($_GET['sent'])) {
            $people = $row['TO'];
        }
        else{
            $people = $row['FROM'];
        }
        $authorName = $data_access->get_($data_access->user_block($people), $people, "nom_reel");
        if(!isset($saveAvatars[$people])) {
            $authorAvatar = $_SESSION['NAAT_ORIGIN_DIRECTORY'].'/'.$tempSecureImage->createTempPic($data_access->get_($data_access->user_block($people), $people, "small_avatar"));
            $saveAvatars[$people] = $authorAvatar;
        }
        else{
            $authorAvatar = $saveAvatars[$people];
        }
        ?>
        <tr<?php if($row['SEEN'] == 0 AND !isset($_GET['sent'])) { echo " class=\"active\""; } ?> onclick="window.location = '<?php echo $_SESSION['NAAT_GOTO_URL']; ?>messages?group=view&id=<?php echo $row['ID']; ?>';" title="Ouvrir le message de @<?php echo $people; ?>">
            <td class="avatar">
                <div class="pic" style="background-image:url('<?php echo $authorAvatar; ?>');"></div>
            </td>
            <td class="name" title="<?php echo $authorName." @".$people; ?>">
                <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>profile?profile_id=<?php echo $people; ?>">
                    <?php echo substr($authorName,0,10); if(strlen($authorName) > 10) { echo "..."; } ?>
                </a>
                <span class="small_indic">@<?php echo $people; ?></span>
            </td>
            <td class="title">
                <?php echo $emojis->transformToSvg(substr($row['TITLE'],0,50)); if(strlen($row['TITLE']) > 50) { echo "..."; } if($row['TITLE'] == "") { echo "Aucun objet pour ce message"; } ?>
            </td>
            <td class="date">
                <?php
                    $date_veille = strftime("%d/%m/%Y", mktime(0, 0, 0, date('m'), date('d')-1, date('y'))); 
                    if(date("d/m/Y", $row['DATE']) == date("d/m/Y")) {
                        ?>
                        <span class="small_indic">
                            Aujourd'hui <?php echo date("à H:i", $row['DATE']); ?> 
                        </span>
                        <?php
                    }
                    elseif(date("d/m/Y", $row['DATE']) == $date_veille) {
                        ?>
                        <span class="small_indic">
                            Hier <?php echo date("à H:i", $row['DATE']); ?> 
                        </span>
                        <?php
                    }
                    else{
                        ?>
                        <span class="small_indic">
                            <?php echo date("d/m/Y à H:i", $row['DATE']); ?>
                        </span>
                        <?php
                    }
                    if(isset($_GET['sent'])) {
                        $db_to = new SQLite3('MNT_DB/'.$data_access->user_block($people).$data_access->user_path($people).'/data.db');
                        if(intval($db_to->query('SELECT "VALUE" as ct_id FROM listing_infos WHERE "NAME" = "confidentialVisibleSeen"')->fetchArray()['ct_id']) == 1) {
                            if($db_to->query('SELECT "SEEN" as ct_id FROM listing_messages WHERE "REFERER_ID" = "'.$row['ID'].'"')->fetchArray()['ct_id'] == 1) {
                                ?>
                                <span class="small_indic">Message vu</span>
                                <?php
                            }
                        }
                    }
                ?>
            </td>
            <td class="options">
                <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>messages?group=view&id=<?php echo $row['ID']; ?>">
                    <img src="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/icons/svg/navigation.svg" width="20px" />
                </a>
            </td>
        </tr>
        <?php
            $date = $row["DATE"];
        }
        ?>
    </table>
    <?php
    if($results_ct < 1) {
        ?>
        <div class="row">
            <div class="col col-padding col-bordered col-sm-10 col-lg-10">
                <p class="error">Aucun message</p>
            </div>
        </div>
        <div class="clear"></div>
        <?php
    }
    ?>

    <?php
    if($results_ct > 20) {
        ?>
        <div class="row">
            <div class="col col-padding col-bordered col-sm-10 col-lg-10">
                <a href="?group=inbox<?php echo isset($_GET['sent']) ? "&sent" : ""; ?>&DATE=<?php echo $date; ?>#posts" class="a-next-posts">Afficher les messages plus anciens</a>
            </div>
        </div>
        <div class="clear"></div>
        <?php
    }
    ?>
</div>