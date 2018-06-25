<?php
function if_has_value($input_name) {
    if(isset($_POST[$input_name])) {
        echo ' value="'.$_POST[$input_name].'"';
    }
}
?>
<div id="login_container_blur" onclick="window.location = '<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>?home';"></div>
<div id="login_container">
    <span class="sec_title">Me créer un compte</span>
    <form method="post" action="?register_form">
        <table class="organize_form">
            <?php
                if(isset($_POST['register'])) {
            ?>
            <tr>
                <td colspan="2">
                    <?php
                        if(isset($_SESSION['returnRegister'])) {
                            echo $_SESSION['returnRegister'];
                            unset($_SESSION['returnRegister']);
                        }
                    ?>
                    <br />
                </td>
            </tr>
            <?php
                }
            ?>
            <tr>
                <td colspan="2">
                    <input type="text" name="real_name"<?php if_has_value("real_name"); ?> placeholder="Prénom et nom *" onfocus="dispSomeHelp('Vous devez indiquer votre nom et prénom');" autofocus />
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="text" name="username"<?php if_has_value("username"); ?> placeholder="Nom d'utilisateur *" onfocus="dispSomeHelp('Le nom d\'utilisateur doit faire moins de 14 caractères et ne peut contenir que des chiffres et des lettres');" autocapitalize="none" />
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="password" name="password" placeholder="Mot de passe *" onfocus="dispSomeHelp('Le mot de passe doit contenir minimum 8 caractères, veillez à ce qu\'il soit complexe');" />
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="password" name="password2" placeholder="Confirmation de mot de passe *" onfocus="dispSomeHelp('Veillez à ce que le mot de passe soit identique à celui indiqué précédemment');" />
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="text" name="email"<?php if_has_value("email"); ?> placeholder="Adresse email *" onfocus="dispSomeHelp('L\'adresse email doit être valide et doit vous appartenir');" />
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p class="p_indic">* champs obligatoires</p>
                    <br />
                    <p class="p_indic">J'accepte les <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>cgu" target="_blank">CGU</a></p><br />
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" name="register" value="Créer un compte" onclick="dispLoadingIcon();" />
                </td>
            </tr>
        </table>
    </form>
</div>