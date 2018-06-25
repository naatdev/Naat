<div style="width: 100vw; height: 100vh; position: fixed; top: 0; left: 0; background-color: rgba(0,0,0,0.35); z-index: 2000;"></div>
<div id="page_content_write_post">
    <?php
        $data_access = new data_access();
        $db = new SQLite3('MNT_DB/'.$data_access->user_block($_SESSION['userName']).$data_access->user_path($_SESSION['userName']).'/data.db');
        $db->busyTimeout(10000);
        $emojis = new emojis();
    ?>
    <div class="close"><a href="?group=posts"><img src="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/icons/svg/multiply-1.svg" class="icon" /></a></div>
    <div class="row">
        <div class="col col-lg-10">
            <form method="POST" action="" id="profile-new-post">
                <input type="text" name="post_title" class="input-full input-selected" placeholder="Titre de votre article" onclick="dispSomeHelp('Vous pouvez saisir un titre, c\'est optionnel);">
                <textarea name="post_content" placeholder="Ecrivez votre article ici ..." id="textareaPost"></textarea>
                <div class="pull_left">
                    <span class="small_indic" id="indicChars">0 caractère</span>
                </div>
                <div class="pull_right">
                    <input type="submit" name="post" value="Publier" onclick="document.getElementById('indicChars').innerHTML = 'Veuillez patienter ...';">
                </div>
                <div style="clear: both;"></div>
            </form>

            <?php
                if(isset($_POST['post_content'])) {
                    if(!empty($_POST['post_content']) AND strlen(html_entity_decode($_POST['post_content'])) < 10001) {
                        $post_content = $_POST['post_content'];

                        if(isset($_POST['post_title']) AND !empty($_POST['post_title']) AND strlen($_POST['post_title']) < 10000) {
                            $post_title = substr($_POST['post_title'], 0, 1000);
                        }else{
                            $post_title = "";
                        }

                        if($db->query('INSERT INTO listing_posts(DATE,TITLE,CONTENT,FROM_IP,PRIVACY) VALUES("'.time().'","'.$post_title.'","'.$post_content.'","'.$_SERVER['REMOTE_ADDR'].'","3")')) {
                            sleep(1);
                            ?>
                            <br />
                            <p class="success">Ce post a été publié sur votre profil !</p>
                            <?php
                        }else{
                            ?>
                            <br />
                            <p class="error">Erreur lors de la publication ...</p>
                            <?php
                        }
                    }else{
                        ?>
                        <br />
                        <p class="error">Veuillez saisir un contenu</p>
                        <?php
                    }
                }
            ?>
            
        </div>
        <div class="col col-lg-10 col-sm-10">
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
    <div class="clear"></div>
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