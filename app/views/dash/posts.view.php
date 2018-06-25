<?php
$data_access = new data_access();
$colors_lib = new giveColorFromEquivalent();
$emojis = new emojis();
$templatePost = new templatePost();
$parsedown = new Parsedown();
$tempSecureImage = new tempSecureImage();
$db = new SQLite3('MNT_DB/'.$data_access->user_block($_SESSION['userName']).$data_access->user_path($_SESSION['userName']).'/data.db');
$db->busyTimeout(10000);
$bubleForDash = $data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], 'currentUserBubleOnDash');
if(!empty($bubleForDash) AND !is_null($bubleForDash)) {
    if($db->query('SELECT count("ID") as ct_id FROM listing_bubles WHERE "ID" = "'.$bubleForDash.'"')->fetchArray()['ct_id'] < 1) {
        $bubleForDash = $db->query('SELECT ID as id FROM listing_bubles ORDER BY ID DESC LIMIT 1"')->fetchArray()['ct_id'];
    }
}
else{
    $bubleForDash = $db->query('SELECT ID as id FROM listing_bubles ORDER BY ID ASC LIMIT 1')->fetchArray()['id'];
}

$id = htmlspecialchars($db->escapeString($bubleForDash));
$results = $db->query('SELECT * FROM listing_bubles WHERE "ID" = "'.$id.'"');

while($row = $results->fetchArray()) {
    $NAME = $row['NAME'];
    $DESCRIPTION = $row['DESCRIPTION'];
    $BUBLE_COLOR = $row['BUBLE_COLOR'];
}
?>
<div id="page_content">
<div class="row">
    <div class="col col-padding col-lg-1">
        <div class="buble_color_circle" style="background-color: <?php echo $colors_lib::giveFromName($BUBLE_COLOR); ?>;">
            <?php echo ucfirst(substr(htmlspecialchars_decode($NAME), 0, 1)); ?>
        </div>
    </div>
    <div class="col col-padding col-lg-9">
        <div class="row">
            <div class="col col-lg-10">
                <span class="page_title"><?php echo $NAME; ?></span>
            </div>
            <div class="col col-lg-10">
                <p class="buble-description">
                    <?php echo $DESCRIPTION; ?>
                </p>
            </div>
        </div>
        <div class="clear"></div>
    <div class="col col-padding col-lg-10">
        <p class="small_indic">Retrouvez ici les dernières actualités des personnes que vous avez ajoutées à cette bulle
            <br />Pour changer la bulle qui s'affiche par défaut en page d'accueil rendez vous dans les paramètres</p>
    </div>
</div>
<div class="clear"></div>

<?php
$results = $db->query('SELECT "USERNAME" FROM listing_bubles_who WHERE "BUBLE_ID" = "'.intval($id).'" ORDER BY "ADD_TIME" DESC');
$usernames = array();

while($row = $results->fetchArray()) {
    if(file_exists('MNT_DB/'.$data_access->user_block($row['USERNAME']).'/'.$data_access->user_path($row['USERNAME']).'/data.db')) {
        $db_ = new SQLite3('MNT_DB/'.$data_access->user_block($row['USERNAME']).'/'.$data_access->user_path($row['USERNAME']).'/data.db');
        $db_->busyTimeout(10000);
        $results_ = $db_->query('SELECT "DATE" FROM listing_posts ORDER BY "ID" DESC LIMIT 1')->fetchArray()['DATE'];
        if($results_ == "") {
            $results_ = 0;
        }
        $usernames[$row['USERNAME']] = $results_;
    }
}
if(!empty($usernames)) {
    asort($usernames);
    $usernames = array_reverse($usernames);
}
$nbrInBuble = 0;
foreach($usernames as $key => $value) {
    $row['USERNAME'] = $key;
    $nbrInBuble++;
?>
<div class="row">
    <?php
    $username = $row['USERNAME'];
    $db_ = new SQLite3('MNT_DB/'.$data_access->user_block($username).'/'.$data_access->user_path($username).'/data.db');
    $db_->busyTimeout(10000);
    $PRIVACY_LEVEL = 3;

    $postsVisibles = $db_->query('SELECT "VALUE" as ct_id FROM "listing_infos" WHERE "NAME" = "confidentialVisiblePosts"')->fetchArray()['ct_id'];
    $visibleForMe = $db_->query('SELECT count("ID") as ct_id FROM "listing_bubles_who" WHERE "USERNAME" = "'.$_SESSION['userName'].'"')->fetchArray()['ct_id'];
    if($postsVisibles == 1) {
        $postsVisibles = 1;
    }
    if($postsVisibles == 0 AND $visibleForMe != 0) {
        $postsVisibles = 1;
    }
    if($username == $_SESSION['userName'] OR $postsVisibles == 1) {

        $results_ = $db_->query('SELECT * FROM listing_posts WHERE "PRIVACY" = "'.$PRIVACY_LEVEL.'" ORDER BY "ID" DESC LIMIT 2');

        $nbr = 0;
        while($row_ = $results_->fetchArray()) {
            $nbr++;
            
                $post = array(
                    "username" => $row['USERNAME'],
                    "real_name" => substr(explode(' ',$data_access->get_($data_access->user_block($row['USERNAME']), $row['USERNAME'], "nom_reel"))[0],0,14),
                    "post_id" => $row_['ID'],
                    "small_avatar_url" => $_SESSION['NAAT_ORIGIN_DIRECTORY'].'/'.$tempSecureImage->createTempPic($data_access->get_($data_access->user_block($row['USERNAME']), $row['USERNAME'], "small_avatar")),
                    "post_title" => $row_['TITLE'],
                    "post_content" => $row_['CONTENT'],
                    "post_date" => $row_['DATE'],
                    "editable" => False,
                    "plus" => $row_['PLUS']
                );

                if(!empty($row_['TITLE'])) {
                    if($row_['NO_FORMAT'] != 1) {
                        $post['post_title'] = $parsedown->setBreaksEnabled(true)->line($emojis->transformToSvg($row_['TITLE']));
                    }
                }

                if($row_['TYPE'] == "NEW_PROFILE_PIC") {
                    $post['post_content'] = "<center><img src='".$_SESSION['NAAT_ORIGIN_DIRECTORY']."/".$tempSecureImage->createTempPic($row_['CONTENT'])."' class='big-avatar' alt='Nouvelle image de profil'></center>";
                }else{
                    if($row_['NO_FORMAT'] != 1) {
                        $post['post_content'] = $parsedown->setBreaksEnabled(true)->text($emojis->transformToSvg(nl2br($row_['CONTENT'])));
                    }
                }

                if($post['username'] == $_SESSION['userName']) {
                    $post['editable'] = True;
                }
                else{
                    $post['editable'] = False;
                }

                echo $templatePost->post(
                    $post['username'],
                    $post['real_name'],
                    $post['post_id'],
                    $post['small_avatar_url'],
                    $post['post_title'],
                    $post['post_content'],
                    $post['post_date'],
                    $post['editable'],
                    $_SESSION['NAAT_GOTO_URL'],
                    True,
                    $post['plus'],
                    True
                );

            }
            
        }

        if($postsVisibles == 1 AND $nbr == 0) {
            ?>
            <br />
            <p class="error">Pas de post récent pour <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>profile?profile_id=<?php echo $username; ?>&ref=posts_dash">@<?php echo $username; ?></a></p>
            <?php
        }
        if($postsVisibles == 0 AND $username != $_SESSION['userName']) {
            ?>
            <br />
            <p class="error"><a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>profile?profile_id=<?php echo $username; ?>&ref=posts_dash">@<?php echo $username; ?></a> ne vous a pas dans ses bulles, vous ne pouvez pas voir ses posts</p>
            <?php
        }
        if($nbr%2 == 0) {
            echo '<div style="clear: both;"></div>';
        }
        ?>
</div>
<div class="clear"></div>
<?php
}
if($nbrInBuble == 0) {
    ?>
    <div class="row">
        <div class="col col-padding col-sm-10 col-lg-10">
            <p class="error">Il n'y a personne dans cette bulle</p>
            <br />
            <p class="info">Ajoutez quelqu'un à cette bulle via sa page profil ;)</p>
        </div>
    </div>
    <div class="clear"></div>
    <?php
}
?>
</div>
</div>