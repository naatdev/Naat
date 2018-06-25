<?php
function if_has_value($input_name) {
    if(isset($_POST[$input_name])) {
        echo ' value="'.htmlspecialchars($_POST[$input_name]).'"';
    }
}
?>
<div id="login_container_blur" onclick="window.location = '<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>?home';"></div>
<div id="login_container">
    <span class="sec_title">Connexion à mon compte</span>
    <form method="post" action="?login_form">
        <table class="organize_form">
            <tr>
                <td colspan="2">
                    <input type="text" name="username"<?php if_has_value("username"); ?> placeholder="Nom d'utilisateur" autocapitalize="none" autofocus />
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="password" name="password" placeholder="Mot de passe" />
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <a href="#" class="forgot_password" onclick="askForID(); dispLoadingIcon();">Mot de passe oublié ?</a>
                    <br /><br />
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" name="login" value="Se connecter" onclick="dispLoadingIcon();" />
                </td>
            </tr>
            <?php
                if(isset($_POST['login'])) {
            ?>
            <tr>
                <td colspan="2">
                    <br />
                    <?php
                        if(isset($_SESSION['returnLogin'])) {
                            echo $_SESSION['returnLogin'];
                            unset($_SESSION['returnLogin']);
                        }
                    ?>
                </td>
            </tr>
            <?php
                }
            ?>
        </table>
    </form>
</div>
<script type="text/javascript">
function askForID() {
    var userName = prompt("Quel est votre nom d'utilisateur ?");
    window.location = "<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/mammut_login.php?recover=" + userName;
}
</script>