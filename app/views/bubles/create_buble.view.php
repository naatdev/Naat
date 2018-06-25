<?php
/*
    Chargement de toutes les librairies nécessaires et de la bdd de l'utilisateur
*/
$data_access = new data_access();
$colors_lib = new giveColorFromEquivalent();
$db = new SQLite3('MNT_DB/'.$data_access->user_block($_SESSION['userName']).$data_access->user_path($_SESSION['userName']).'/data.db');
$db->busyTimeout(10000);
$nbrBubles = $db->query('SELECT count("ID") as ct_id FROM listing_bubles')->fetchArray()['ct_id'];
?>
<div id="page_content">
    <div class="row">
        <div class="col col-padding col-sm-10 col-lg-10">
            <h1 class="page_title">Créer une bulle</h1>
            <span class="page_information">Informations générales</span>
            <br />

            <form method="POST" action="" id="create_buble" onsubmit="dispLoadingIcon();">
                <div class="row">
                    <div class="col col-text-align-center col-sm-10 col-lg-10">
                        <input type="text" name="NAME" placeholder="Nom de la bulle" value="<?php if(isset($_POST['NAME'])) {echo htmlspecialchars($_POST['NAME']);} ?>">
                    </div>
                    <div class="col col-text-align-center col-sm-10 col-lg-10">
                        <textarea name="DESCRIPTION" rows="5" placeholder="Description de la bulle" id="textareaPost" onkeyup="countChars();"><?php if(isset($_POST['DESCRIPTION'])) {echo htmlspecialchars($_POST['DESCRIPTION']);} ?></textarea>   
                    </div>
                </div>
                <div class="clear"></div>

                <div class="row">
                    <div class="col col-padding col-sm-10 col-lg-7">
                        <select name="BUBLE_COLOR" class="settings-select" onchange="previewColor(this.value);">
                            <?php
                            foreach($colors_lib::giveColors() as $key => $value) {
                                ?>
                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        &nbsp;&nbsp;<span class="small_indic" id="indicChars">0 caractère</span>
                    </div>
                    <div class="col col-padding col-text-align-right col-sm-10 col-lg-3">
                        <input type="submit" name="create" value="Créer" class="form_input_submit_login" id="submit_btn" onclick="dispLoadingIcon('Création de votre bulle ...');">
                    </div>
                </div>
                <div class="clear"></div>
            </form>
            <?php
                if(isset($_POST['create'])) {
                    if(isset($_POST['NAME']) AND !empty($_POST['NAME']) AND strlen($_POST['NAME']) < 1500) {

                        $newName = $_POST['NAME'];

                        $newDescription = "";
                        if(isset($_POST['DESCRIPTION']) AND !empty($_POST['DESCRIPTION'])) {
                            if(strlen($_POST['DESCRIPTION']) < 10001) {
                                $newDescription = $_POST['DESCRIPTION'];
                            }
                            else{
                                $newDescription = substr($_POST['DESCRIPTION'], 0, 10000);
                            }
                        }
                        
                        $colors = $colors_lib::giveColorsList();
                        if(isset($_POST['BUBLE_COLOR']) AND !empty($_POST['BUBLE_COLOR']) AND in_array($_POST['BUBLE_COLOR'], $colors)) {
                            $newColor = htmlspecialchars($db->escapeString($_POST['BUBLE_COLOR']));

                            if($db->query('INSERT INTO listing_bubles("NAME","DESCRIPTION","BUBLE_COLOR","CTIME") VALUES("'.$newName.'","'.$newDescription.'","'.$newColor.'","'.time().'")')) {
                                sleep(1);
                                Header('Location: '.$_SESSION['NAAT_GOTO_URL'].'dash?success_buble_created');
                                Exit(); //optional
                            }
                            else{
                                echo "<br /><p class='danger'>Erreur</p><br />";
                            }
                        }

                    }
                    else{
                        echo "<br /><p class='error'>Veuillez indiquer un nom</p><br />";
                    }
                }
            ?>
        </div>
    </div>
    <div class="clear"></div>
</div>

<div id="dash_bubles_preview">
    <?php $this->viewLoad("parts/bubles_list"); ?>
</div>

<script type="text/javascript">
    function previewColor(color) {
        var colors = new Array();
        <?php
        foreach($colors_lib::giveColorsFromName() as $key => $value) {
            ?>
            colors['<?php echo $key ?>'] = "<?php echo $value; ?>";
            <?php
        }
        ?>
        var color_ = colors[color];
        document.getElementById("submit_btn").style = "background-color: " + color_ + ";";
        document.getElementById("small_avatar_buble").style = "background-color: " + color_ + ";";
    }

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
        if(nbrChars > 1) {
            var s = "s";
        }
        else{
            var s = "";
        }
        indicChars.innerHTML = nbrChars + "/" + nbrCharMaxInTextarea;
    }
</script>