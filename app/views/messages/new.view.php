<div id="page_content_mails">
<?php
/*
    On charge les librairies nécessaires
*/
$data_access = new data_access();
$tempSecureImage = new tempSecureImage();
$emojis = new emojis();

if(isset($_GET['dest']) AND !empty($_GET['dest']) AND ctype_alnum($_GET['dest'])) {
    if(!$data_access->get_($data_access->user_block($_GET['dest']), $_GET['dest'], "username")) {
        Header("Location: ".$_SESSION['NAAT_GOTO_URL']."messages?group=inbox");
        Exit();
    }
}
else{
    Header("Location: ".$_SESSION['NAAT_GOTO_URL']."messages?group=inbox");
    Exit();
}

$db = new SQLite3('MNT_DB/'.$data_access->user_block($_GET['dest']).$data_access->user_path($_GET['dest']).'/data.db');
$db->busyTimeout(10000);
$db_me = new SQLite3('MNT_DB/'.$data_access->user_block($_SESSION['userName']).$data_access->user_path($_SESSION['userName']).'/data.db');
$db_me->busyTimeout(10000);

$dest = htmlspecialchars($_GET['dest']);
$avatarDest = $_SESSION['NAAT_ORIGIN_DIRECTORY'].'/'.$tempSecureImage->createTempPic($data_access->get_($data_access->user_block($dest), $dest, "small_avatar"));
$realNameDest = $data_access->get_($data_access->user_block($_GET['dest']), $_GET['dest'], "nom_reel");
?>

    <div class="row">
        <div class="col col-padding col-lg-10">
            <span class="page_title">Nouveau message à<?php echo "&nbsp;@".$dest; ?></span>&nbsp;&nbsp;<span class="small_indic" style="font-size:15px;"><?php echo $realNameDest; ?></span>
        </div>

        <div class="col col-padding col-lg-10">
                <?php
                    if(isset($_GET['success'])) {
                        echo "<p class='success'>Message envoyé</p><br />";
                    }
                    if(isset($_POST['send'])) {
                        if(!isset($_POST['message_title']) OR !isset($_POST['message_content']) OR empty($_POST['message_content'])) {
                            echo "<p class='error'>Veuillez remplir les champs</p><br />";
                        }
                        else{
                            $title = $db->escapeString($_POST['message_title']);
                            $content = $db->escapeString($_POST['message_content']);
                            if(strlen($content) < 10001) {
                                $REFERER_ID = intval($db_me->query('SELECT "ID" as ct_id FROM listing_messages ORDER BY "ID" DESC LIMIT 1')->fetchArray()['ct_id'])+1;
                                $query = "INSERT INTO listing_messages('DATE','FROM','TO','TITLE','MESSAGE','IP_FROM','REFERER_ID') VALUES('".time()."','".$_SESSION['userName']."','".$dest."','".$title."','".$content."','".$_SERVER['REMOTE_ADDR']."','".$REFERER_ID."')";

                                if($db->query($query) AND $db_me->query($query)) {
                                    sleep(1);
                                    Header('Location: '.$_SESSION['NAAT_GOTO_URL'].'messages?group=new&dest='.$dest.'&success');
                                    Exit(); //optional
                                }
                                else{
                                    echo "<p class='error'>Echec de l'envoi</p><br />";
                                }
                            }
                            else{
                                echo "<p class='error'>Il ya trop de caractères</p><br />";
                            }
                        }
                    }
                ?>

                <form method="POST" action="" id="messages-new-message">
                    <input type="text" name="message_title" class="input-full" value="<?php if(isset($_POST['message_title']) AND !empty($_POST['message_title'])) {echo $_POST['message_title'];} ?>" placeholder="Titre de votre message (optionel)">
                    <textarea name="message_content" rows="5" class="input-full" placeholder="Saisissez votre message ici ..." id="textareaPost"><?php if(isset($_POST['message_content']) AND !empty($_POST['message_content'])) {echo $_POST['message_content'];} ?></textarea>
                        <div class="row">
                            <div class="col col-lg-1">
                                <div id="small_avatar_me" style="background-image:url('<?php echo $avatarDest; ?>');"></div>
                            </div>
                            <div class="col col-lg-6">
                                <?php echo substr($realNameDest,0,30); if(strlen($realNameDest) > 30) { echo "..."; } ?><br />
                                <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>profile?profile_id=<?php echo $dest; ?>">@<?php echo $dest; ?></a>
                            </div>
                            <div class="col col-lg-3 col-text-align-right">
                                <span class="small_indic" id="indicChars">0 caractère</span>
                                <br /><br />
                                <input type="submit" name="send" value="Envoyer" class="form_input_submit_login" onclick="dispLoadingIcon('Envoi de votre message ...');">
                            </div>
                        </div>
                        <div class="clear"></div>
                </form>  	
        </div>
        <div class="col col-padding col-lg-10">
            <span class="small_indic">Emojis disponibles:</span>
            <br /><br />
            <table id="emojisList">
                <?php
                    $nbr = 0;
                    foreach($emojis->emojisList() as $key => $value) {
                        if($nbr % 17 == 0) {
                            echo "<tr>";
                        }
                        ?>
                        <td>
                            <img src="<?php echo $emojis->emojisLink($key); ?>" class="icon" title="<?php echo $key; ?>" onclick="addText(' <?php echo str_replace("'", "\'", $key); ?> ');" /> 
                        </td>
                        <?php
                        $nbr++;
                        if($nbr % 17 == 0) {
                            echo "</tr>";
                        }
                    }
                ?>
            </table>
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
	spellChecker: false,
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
    function addText(texttoadd) {
        var codeeditor = simplemde.codemirror;
        var previous = codeeditor.getSelection();
        var output = previous + texttoadd;
        codeeditor.replaceSelection(output);
    }
</script>