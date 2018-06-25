<?php
$data_access = new data_access();
$tempSecureImage = new tempSecureImage();
$parsedown = new Parsedown();
$emojis = new emojis();
$templatePost = new templatePost();


$PRIVACY_LEVEL = 3;

$username = htmlspecialchars($_GET['profile_id']);
$db = new SQLite3('./MNT_DB/'.$data_access->user_block($username).'/'.$data_access->user_path($username).'/data.db');
$db->busyTimeout(10000);

$postsVisibles = 0;
$postsVisibles = $db->query('SELECT "VALUE" as ct_id FROM "listing_infos" WHERE "NAME" = "confidentialVisiblePosts"')->fetchArray()['ct_id'];
$visibleForMe = $db->query('SELECT count("ID") as ct_id FROM "listing_bubles_who" WHERE "USERNAME" = "'.$_SESSION['userName'].'"')->fetchArray()['ct_id'];
if($postsVisibles == 1) {
    $postsVisibles = 1;
}
if($postsVisibles == 0 AND $visibleForMe != 0) {
    $postsVisibles = 1;
}
if($username == $_SESSION['userName'] OR $postsVisibles == 1) {

    if(isset($_GET['add_plus'])) {
        if(isset($_GET['post_id']) AND !empty($_GET['post_id']) AND is_numeric($_GET['post_id'])) {
            $ID = htmlspecialchars($_GET['post_id']);
            if(!isset($_SESSION['PLUS_ON_POST_'.$ID.'_OF_'.$username])) {
                if($db->query('SELECT count("ID") as ct_id FROM listing_posts WHERE "ID" = "'.$ID.'"')->fetchArray()['ct_id'] > 0) {
                    $db->query('UPDATE listing_posts SET "PLUS" = "PLUS"+1 WHERE "ID" = "'.$ID.'"');
                    sleep(1);
                    $_SESSION['PLUS_ON_POST_'.$ID.'_OF_'.$username] = True;
                    $dateifneeded = '';
                    if(isset($_GET['DATE'])) {
                        $dateifneeded = '&DATE='.$_GET['DATE'];
                    }
                    Header('Location: '.$_SESSION['NAAT_GOTO_URL'].'profile?profile_id='.$username.$dateifneeded.'#post_id_'.$ID);
                    Exit(); //optional
                }
            }
            else{
                echo "<script type='text/javascript'>alert('Un seul plus est accordable par session et par article.');</script>";
            }
        }
    }
    if(!isset($_GET['DATE']) OR empty($_GET['DATE']) OR !is_numeric($_GET['DATE'])) {
        $results_ct = $db->query('SELECT count("ID") as ct_id FROM listing_posts WHERE "PRIVACY" = "'.$PRIVACY_LEVEL.'"')->fetchArray()['ct_id'];
        $results = $db->query('SELECT * FROM listing_posts WHERE "PRIVACY" = "'.$PRIVACY_LEVEL.'" ORDER BY "ID" DESC LIMIT 20');
    }
    else{
        $results = $db->query('SELECT * FROM listing_posts WHERE "PRIVACY" = "'.$PRIVACY_LEVEL.'" AND "DATE" < "'.$db->escapeString($_GET['DATE']).'" ORDER BY "ID" DESC LIMIT 20');
        $results_ct = $db->query('SELECT count("ID") as ct_id FROM listing_posts WHERE "PRIVACY" = "'.$PRIVACY_LEVEL.'" AND "DATE" < "'.$db->escapeString($_GET['DATE']).'"')->fetchArray()['ct_id'];
    }

    while($row = $results->fetchArray()) {
        if(intval($row['PLUS']) < 1) {
            $row['PLUS'] = 0;
        }
        $post = array(
            "username" => $username,
            "real_name" => explode(' ', $data_access->get_($data_access->user_block($username), $username, "nom_reel"))[0],
            "post_id" => $row['ID'],
            "small_avatar_url" => $_SESSION['NAAT_ORIGIN_DIRECTORY'].'/'.$tempSecureImage->createTempPic($data_access->get_($data_access->user_block($username), $username, "small_avatar")),
            "post_title" => $row['TITLE'],
            "post_content" => $row['CONTENT'],
            "post_date" => $row['DATE'],
            "editable" => False,
            "plus" => $row['PLUS']
        );
        if(!empty($row['TITLE'])) {
            if($row['NO_FORMAT'] != 1) {
                $post['post_title'] = $emojis->transformToSvg($parsedown->setBreaksEnabled(true)->line($row['TITLE']));
            }
        }

        if($row['TYPE'] == "NEW_PROFILE_PIC") {
            $post['post_content'] = "<center><img src='".$_SESSION['NAAT_ORIGIN_DIRECTORY']."/".$tempSecureImage->createTempPic($row['CONTENT'])."' class='big-avatar' alt='Nouvelle image de profil'></center>";
        }else{
            if($row['NO_FORMAT'] != 1) {
                $post['post_content'] = $emojis->transformToSvg($parsedown->setBreaksEnabled(true)->text(nl2br($row['CONTENT'])));
            }
        }

        if($username == $_SESSION['userName']) {
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
            
        $date = $row["DATE"];
    }

            if($results_ct < 1) {
                ?>
                <div class="row">
                    <div class="col col-white col-bordered col-sm-10 col-lg-10">
                        <br />
                            <p class="error">
                                Aucun article publié dernièrement ou visible actuellement
                            </p>
                        <br />
                    </div>
                </div>
            <?php
            }
            ?>

            <?php
            if($results_ct > 20) {
            ?>
                <div class="row">
                    <div class="col col-white col-bordered col-sm-10 col-lg-10">
                        <a href="?profile_id=<?php echo $username; ?>&DATE=<?php echo $date; ?>#posts" class="a-next-posts">Afficher les posts plus anciens</a>
                    </div>
                </div>
            <?php
            }
}
else{
?>
            <div class="row">
                <div class="col col-white col-bordered col-sm-10 col-lg-10">
                    <br />
                        <p class="error">
                            Aucun article publié dernièrement ou visible actuellement
                        </p>    
                    <br />
                </div>
            </div>
<?php
}
?>