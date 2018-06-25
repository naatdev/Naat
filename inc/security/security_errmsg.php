<?php
if(!isset($_SESSION['NAAT_SECURITY_RETRIES'])) {
    $_SESSION['NAAT_SECURITY_RETRIES'] = 0;
}
$_SESSION['NAAT_SECURITY_RETRIES']++;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>naat security</title>
    </head>
    <body>
        <div style="color:red;padding:10px;border:1px dashed red;">
            <font size="25px">Erreur mauvaise requête</font>
            <br />
            L'accès à cette ressouce est temporairement bloquée par mesure de sécurité.
            <br />
            <br />
            IP Client: <?php echo $_SERVER['REMOTE_ADDR'].', '.$_SERVER['HTTP_USER_AGENT']; ?>
            <br /><br />
            naät security plugin - <?php echo date('d-m-Y H:i:s'); ?>
            <br />
            nombre de requêtes non conformes pour cette session: <?php echo $_SESSION['NAAT_SECURITY_RETRIES']; ?>
        </div>
    </body>
</html>