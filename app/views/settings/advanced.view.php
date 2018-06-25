<span class="page_title">Paramètres avancés du compte</span>

<form method="POST" action="">
    <table id="interfaceSettingsTable">
        <tr>
            <td>
                <img src="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/icons/svg/locked.svg" width="20px" style="vertical-align:middle;" />&nbsp;&nbsp;<span>Changer de mot de passe</span>
            <?php
                if(isset($_POST['modify_password'])) {
                    $error = False;
                    if(!isset($_POST['password_new']) OR empty($_POST['password_new']) OR !isset($_POST['password_new_']) OR empty($_POST['password_new_']) OR !isset($_POST['password_actuel']) OR empty($_POST['password_actuel'])) {
                        echo "<br /><p class='error'>Veuillez tout remplir</p><br />";
                        $error = True;
                    }
                    else {
                        if($_POST['password_new'] != $_POST['password_new_']) {
                            echo "<br /><p class='error'>Les mots de passe sont différents</p><br />";
                            $error = True;
                        }
                        else{
                            if(strlen($_POST['password_new']) < 7) {
                                echo "<br /><p class='error'>Le mot de passe est trop court</p><br />";
                                $error = True;
                            }
                            else{
                                $exPasswordInput = $data_access->returncoded($_POST['password_actuel']);
                                $exPasswordSaved = $data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "key");
                                if($exPasswordInput != $exPasswordSaved) {
                                    echo "<br /><p class='error'>Le mot de passe actuel est différent</p><br />";
                                    $error = True;
                                }
                                if($error == False) {
                                    $newPassword = $data_access->returncoded($_POST['password_new_']);
                                    if($data_access->set_($_SESSION['currentUserBlock'], $_SESSION['userName'], "key", $newPassword, True)) {
                                        echo "<br /><p class='success'>Le mot de passe est modifié</p><br />";
                                    }
                                }
                            }
                        }
                    }
                }
            ?>
            </td>
            <td>
                <input type="password" name="password_actuel" class="input-full" placeholder="Mot de passe actuel"><br /><br />
                <input type="password" name="password_new" class="input-full" placeholder="Nouveau mot de passe"><br /><br />
                <input type="password" name="password_new_" class="input-full" placeholder="Nouveau mot de passe (encore)"><br /><br />
                <input type="submit" name="modify_password" value="Modifier" class="form_input_submit_reset_password" onclick="dispLoadingIcon();">
                <span class="small_indic">&nbsp;&nbsp;(Au moins 7 caractères)</span>
            </td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <br />Voici nos recommandations en terme de sécurité: votre mot de passe doit contenir 7 caractères au minimum,
                <br />il est préférable qu'il contienne des caractères spéciaux (comme: @^*/#~)
                <br />ainsi qu'une ou plusieurs majuscules et un ou plusieurs chiffres.
                <br />Enfin, veillez à ce qu'il ne soit pas devinable, c'est-à-dire qu'il ne contienne pas
                <br />d'information personnelle comme le nom d'un animal ou encore une suite de caractères
                <br />ayant un sens comme un prénom ou un nom.
                <br /><br />Voici un exemple de mot de passe sécurisé:
                <br /><br />
                &nbsp;&nbsp;&nbsp;&nbsp;<span class="info">
                <?php
                    if(rand(0,1) == 1) {
                        echo rand(1000,9999);
                    }
                    else{
                        for($i = 0; $i < rand(1,3); $i++) {
                            echo array('a','AZ','#','9','e','~','Ui','$5','89','-(','S','Q','o','p','B','C','r','u','w')[rand(0,18)];
                        }
                    }
                    echo array('a','AZ','#','9','e','~','Ui','$5','89','-(','S','Q','o','p','B','C','r','u','w')[rand(0,18)];
                    echo rand(1000,9999);
                    echo array('a','AZ','#','9','e','~','Ui','$5','89','-(','S','Q','o','p','B','C','r','u','w')[rand(0,18)];
                    echo array('a','AZ','#','9','e','~','Ui','$5','89','-(','S','Q','o','p','B','C','r','u','w')[rand(0,18)];
                    echo array('a','AZ','#','9','e','~','Ui','$5','89','-(','S','Q','o','p','B','C','r','u','w')[rand(0,18)];
                ?>
                </span>
            </td>
            <td></td>
        </tr>
    </table>
</form>