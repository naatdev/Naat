<div id="overlay_container_blur" onclick="window.location = '<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>?home';"></div>
<div id="overlay_container_close"><a href="?home">X</a></div>
<div id="overlay_container">
    <div id="profile_new_post">
        <form method="POST" action="" id="">
            <input type="text" name="post_title" class="input_title" placeholder="Ajouter un titre à ma publication" />
            <textarea name="post_content" rows="7" class="input_content" placeholder="Racontez ici votre plus belle histoire à partager :)" id="textareaPost" onkeyup="countChars();"></textarea>
            <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
            <div class="pull_left">
                &nbsp;&nbsp;&nbsp;&nbsp;
                <span class="small_indic" id="indicChars">0 caractère</span>
            </div>
            <div class="pull_right">
                <input type="submit" name="post" value="Publier" class="input_post" onclick="document.getElementById('indicChars').innerHTML = 'Veuillez patienter ...';" />
            </div>
            <div style="clear: both;"></div>
        </form>
        <?php
            if(isset($_POST['post_content'])) {
                $posts = new posts();
                ?>
            <div id="form_submit_response_profile_new_post">
                <?php
                $posts->new_post();
                ?>
            </div>
                <?php
            }
        ?>
    </div>
</div>

<script type="text/javascript">
var nbrCharMaxInTextarea = 10000;
    var indicChars = document.getElementById("indicChars");

    function countChars() {
        var strInTextarea = document.getElementById("textareaPost").value;
        var nbrChars = strInTextarea.length;
        if(nbrChars > nbrCharMaxInTextarea) { 
            indicChars.style = "color: #F00;";
        }
        else{
            indicChars.style = "";
        }
        if(nbrChars > 9999) {
            var s = "s";
        }
        else{
            var s = "";
        }
        indicChars.innerHTML = "Encore " + (nbrCharMaxInTextarea-nbrChars) + " caractère" + s + " disponibles";
    }
</script>