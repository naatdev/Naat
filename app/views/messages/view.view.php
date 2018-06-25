<?php
/*
    On vérifie qu'un message est spécifié dans l'url et qu'il existe
*/
if(isset($_GET['id']) AND !empty($_GET['id']) AND is_numeric($_GET['id'])) {
    $data_access = new data_access();
    $tempSecureImage = new tempSecureImage();
    $emojis = new emojis();
    $parsedown = new Parsedown();
    $db = new SQLite3('MNT_DB/'.$data_access->user_block($_SESSION['userName']).$data_access->user_path($_SESSION['userName']).'/data.db');
    $db->busyTimeout(10000);
    $id = htmlspecialchars($db->escapeString($_GET['id']));
    if($db->query('SELECT count("ID") as ct_id FROM listing_messages WHERE "ID" = "'.$id.'"')->fetchArray()['ct_id'] < 1) {
        header("Location: ".$_SESSION['NAAT_GOTO_URL']."messages");
        exit();
    }
}
else{
    header("Location: ".$_SESSION['NAAT_GOTO_URL']."messages");
    exit();
}

/*
    Récupération du message et modification de son status de lecture
*/
$results = $db->query('SELECT * FROM listing_messages WHERE "ID" = "'.$id.'" AND "ARCHIVED" != "1"');
$unSeen = $db->query('UPDATE listing_messages SET "SEEN" = "1" WHERE "ID" = "'.$id.'" AND "FROM" != "'.$_SESSION['userName'].'"');
$count_bubles = 0;

/*
    Récupération du mesage et des infos de l'expéditeur
*/
while($row = $results->fetchArray()) {
    $title = $row['TITLE'];
    $content = $row['MESSAGE'];
    $from = htmlspecialchars($db->escapeString($row['FROM']));
    $date = date("d-m-Y à H:i", $row['DATE']);
    $dateTime = $row['DATE'];
    $fromMe = False;
    $strState = "";
    if($from == $_SESSION['userName']) {
        $fromMe = True;
        $from = $row['TO'];
        $strState = "Envoyé";
    }
    $avatarDest = $_SESSION['NAAT_ORIGIN_DIRECTORY'].'/'.$tempSecureImage->createTempPic($data_access->get_($data_access->user_block($from), $from, "small_avatar"));
    $realNameDest = $data_access->get_($data_access->user_block($from), $from, "nom_reel");
    /*
        Si on a demandé à le supprimer
        CREATE TABLE `messages_history` ( `ID` INTEGER PRIMARY KEY AUTOINCREMENT, 
        `DATE` TEXT, 
        `FROM` TEXT, 
        `TO` TEXT, 
        `TITLE` TEXT, 
        `MESSAGE` TEXT, 
        `IP_FROM` TEXT, 
        `IMPORTANT` INTEGER DEFAULT 3, 
        `SEEN` TEXT DEFAULT 0, 
        `REFERER_ID` TEXT DEFAULT 0, 
        `DATE_DEL` TEXT, 
        `IP_DEL` TEXT )
    */
    if(isset($_GET['del_msg'])) {
        if($db->query('INSERT INTO messages_history("DATE","FROM","TO","TITLE","MESSAGE","IP_FROM","IMPORTANT","SEEN","REFERER_ID","DATE_DEL","IP_DEL") VALUES("'.$dateTime.'","'.$from.'","","'.$title.'","'.$content.'","'.$row['IP_FROM'].'","'.$row['IMPORTANT'].'","1","'.$row['REFERER_ID'].'","'.time().'","'.$_SERVER['REMOTE_ADDR'].'")')) {
            if($db->query('DELETE FROM listing_messages WHERE "ID" = "'.$id.'"')) {
                Header('Location: '.$_SESSION['NAAT_GOTO_URL'].'messages?group=inbox&success_del');
                Exit(); //optional
            }
        }
    }
    /*
        Heure du message
    */
    if(date("d/m/Y", $row['DATE']) == date("d/m/Y")) {
        $dateStr = "Aujourd'hui à ".date("H:i", $dateTime);
    }
    else{
        $dateStr = date("d/m/Y à H:i", $dateTime);
    }
}
?>

<div id="page_content" class="mailView">
    <div class="row">
        <div class="col col-padding col-lg-10">
            <span class="page_title">Message <?php echo ($fromMe == True) ? "à" : "de"; echo "&nbsp;@".$from; ?></span>&nbsp;&nbsp;<span class="small_indic" style="font-size:15px;"><?php echo $realNameDest; ?></span>
        </div>
    </div>
    <div class="clear"></div>
    <div class="row">
        <div class="col col-padding col-lg-10">
            <div class="row">
                <div class="col col-lg-1">
                    <div id="small_avatar_me" style="background-image:url('<?php echo $avatarDest; ?>');"></div>
                </div>
                <div class="col col-lg-6">
                    <?php echo substr($realNameDest,0,30); ?><br />
                    <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>profile?profile_id=<?php echo $from; ?>">@<?php echo $from; ?></a>
                </div>
                <div class="col col-padding col-lg-3 col-text-align-right">
                    <?php echo $dateStr; ?>
                </div>
            </div>
            <div class="clear"></div>
            <div class="row col-padding">
                <div class="col col-padding col-lg-10">
                    <span class="title">Objet: <?php echo $emojis->transformToSvg($title); ?></span>
                </div>
                <div class="col col-padding col-lg-10">
                    <p class="message"><?php echo $parsedown->setBreaksEnabled(true)->text(nl2br($emojis->transformToSvg($content))); ?></p>
                </div>
                <div class="col col-padding col-lg-10 col-text-align-right">
                    <?php if($fromMe != True) { ?>
                        <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>messages?group=new&dest=<?php echo $from; ?>" class="answer-btn">Répondre</a>
                    <?php } ?>
                        <button class="del-btn" onclick="if(confirm('Supprimer ce message ?')){window.location='<?php echo $_SESSION['NAAT_GOTO_URL']; ?>messages?group=view&id=<?php echo $id; ?>&del_msg<?php if($fromMe == True) { echo '&sent'; } ?>';}">Supprimer</button>
                    <?php
                        if($fromMe != True) {
                            ?>
                            <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>signalement?type_msg&id=<?php echo $id; ?>" class="msg-option">Signaler</a>
                            <?php
                        }
                    ?>
                </div>
            </div>
            <div class="clear">
        </div>
</div>