<?php
$data_access = new data_access();
$db = new SQLite3('MNT_DB/'.$data_access->user_block($_SESSION['userName']).$data_access->user_path($_SESSION['userName']).'/data.db');
$db->busyTimeout(10000);
$id_post = htmlspecialchars($db->escapeString($_GET['post_id']));
$results = $db->query('SELECT * FROM listing_posts WHERE "ID" = "'.$id_post.'"');
$uneditables = array("NEW_PROFILE_PIC", "NEW_PROFILE_BIO");
?>
<div id="page_content">
    <div class="row">
        <?php
            if(isset($_GET['success_edited'])) {
        ?>
        <div class="col col-padding col-lg-10 col-sm-10">
            <p class="success">Ce post a été modifié !</p>
        </div>
        <?php
            }
        ?>
        <div class="col col-padding col-lg-10 col-sm-10">

            <p>
                <span class="page_title">Modifier un post</span>
                <br /><br />
                &nbsp;&nbsp;<a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>profile?profile_id=<?php echo $_SESSION['userName']; ?>#post_id_<?php echo $id_post; ?>">Retour</a>
            </p>
                <br />

        <?php
            while ($row = $results->fetchArray()) {
                $TYPE = $row['TYPE'];
        ?>
            <form method="POST" action="" id="profile-new-post">
            <?php
                if(!in_array($row['TYPE'], $uneditables)) {
            ?>
                <textarea name="post_content" rows="10" class="input_full" placeholder="Dites aux personnes qui vous suivent comment vous allez et ce que vous ressentez :)" id="textareaPost" onkeyup="countChars();"><?php echo $row['CONTENT']; ?></textarea>
            <?php
                }
                else{
                    $CONTENT = $row['CONTENT'];
                }
            ?>
                <div class="pull-left">
                    <input type="text" name="post_title" class="input_full" placeholder="Titre (optionel)" value="<?php echo $row['TITLE']; ?>">
                    <br />
            <?php
                if(!in_array($row['TYPE'], $uneditables)) {
            ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="small_indic" id="indicChars">0 caractère</span>&nbsp;&nbsp;<span class="small_indic">Publié le <?php echo date('d/m/Y à H:i:s', $row['DATE']); ?></span>
            <?php
                }
            ?>
                </div>
                <div class="pull_right">
                    <input type="submit" name="post" value="Modifier cet article" class="form_input_submit_login" onclick="dispLoadingIcon('Enregistrement des modifications');">
                    <br /><br /><br /><br /><br />
                    <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>edit_post?post_id=<?php echo $row['ID']; ?>&del_post" class="suppr_post" onclick="dispLoadingIcon('Suppression de ce post');">Supprimer ce post</a>
                </div>
                <div style="clear: both;"></div>

                <?php
                if(isset($_GET['del_post'])) {
                    if($db->query('INSERT INTO posts_history("POST_ID","DATE","STATE","TITLE","CONTENT","FROM_IP","PRIVACY") VALUES("'.$row['ID'].'","'.time().'","DELETED","'.$row['TITLE'].'","'.$row['CONTENT'].'","'.$_SERVER['REMOTE_ADDR'].'","3")') AND $db->query('DELETE FROM listing_posts WHERE "ID" = "'.$row['ID'].'"')) {
                        sleep(1);
                        header("Location: ".$_SESSION['NAAT_GOTO_URL']."profile?profile_id=".$_SESSION['userName']);
                    }else{
                        ?>
                        <p class="error">Erreur lors de la suppression ...</p>
                        <?php
                    }
                }
                if(isset($_POST['post'])) {
                    if(in_array($TYPE, $uneditables)) {
                        $_POST['post_content'] = " ";
                    }
                    if(!empty($_POST['post_content']) AND strlen($_POST['post_content']) < 10001) {
                        $post_content = $_POST['post_content'];
                        if(in_array($TYPE, $uneditables)) {
                            $post_content = $CONTENT;
                        }

                        if(isset($_POST['post_title']) AND !empty($_POST['post_title']) AND strlen($_POST['post_title']) < 10000) {
                            $post_title = substr($_POST['post_title'], 0, 1000);
                        }else{
                            $post_title = "";
                        }

                        $db->query('INSERT INTO posts_history("POST_ID","DATE","STATE","TITLE","CONTENT","FROM_IP","PRIVACY") VALUES("'.$row['ID'].'","'.time().'","MODIFIED","'.$row['TITLE'].'","'.$row['CONTENT'].'","'.$_SERVER['REMOTE_ADDR'].'","3")');

                        if($db->query('UPDATE listing_posts SET "TITLE" = "'.$post_title.'", "CONTENT" = "'.$post_content.'", "M_TIME" = "'.time().'", "M_IP" = "'.$_SERVER['REMOTE_ADDR'].'" WHERE "ID" = "'.$row['ID'].'"')) {
                            sleep(1);
                            header("Location: ".$_SESSION['NAAT_GOTO_URL']."edit_post?post_id=".$id_post."&success_edited");
                            }else{
                        ?>
                            <p class="error">Erreur lors de la modification ...</p>
                        <?php
                        }
                    }else{
                        ?>
                        <p class="error">Veuillez remplir les champs</p>
                        <?php
                    }
                }
                ?>
            </form>
        <?php
            }
        ?>

        </div>
    </div>
</div>

<script src="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/js/simplemde.min.js" type="text/javascript"></script>
<script src="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/js/showdown.min.js" type="text/javascript"></script>
<script type="text/javascript">
var simplemde = new SimpleMDE({
    element: document.getElementById("textareaPost"),
    hideIcons: ["guide", "preview", "fullscreen", "side-by-side"],
    promptURLs: true,
    shortcuts: {
		"toggleSideBySide": null,
		"toggleFullScreen": null
    },
    previewRender: function(plainText) {
		setTimeout(function(){
            var converter = new showdown.Converter();
			document.getElementById("preview").innerHTML = converter.makeHtml(plainText);
		}, 250);
	},
    status: [{
		onUpdate: function(el) {
            var nbrChars = simplemde.value().length;
            if(nbrChars > 10000) { 
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
			document.getElementById("indicChars").innerHTML = nbrChars + " caractère" + s + " sur 10000";
		}
	}]
    });
</script>