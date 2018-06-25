<?php
session_start();
if(isset($_SESSION['userName'])) {
    Die("Impossible, vous êtes connecté!");
}
include_once("../app/libs/data_access.lib.php");
$data_access = new data_access("../");
$home = "http://".$_SERVER['HTTP_HOST'].str_replace("/inc/mammut_login.php","",$_SERVER['SCRIPT_NAME']);
$style = "
<style>
* { margin: 0; padding: 0; }
body {
    padding: 50px;
    color: #555;
    font-family: sans-serif;
    text-align: center;
}
a {
    text-decoration: none;
    background-color: #3bafda;
    color: #FEFEFE;
    font-size: 12px;
    padding: 10px 20px 10px 20px;
    border-radius: 7px;
    line-height: 70px;
}
</style>";
if(isset($_GET['recover']) AND !empty($_GET['recover']) AND ctype_alpha($_GET['recover'])) {
    $recover = $_GET['recover'];
    if($data_access->get_($data_access->user_block($recover), $recover, 'key')) {
        $key = rand(rand(123456789, 987654321), rand(12345678999, 98765432100));
        $data_access->set_($data_access->user_block($recover), $recover, "verification_mdp", $key, True);
        $mail = $data_access->get_($data_access->user_block($recover), $recover, 'email');
        $subject = "naät - demande de nouveau mot de passe";
        $message = "Une demande de nouveau mot de passe a eu lieue le ".date("d-m-Y à H:i:s")." depuis l'IP ".$_SERVER['REMOTE_ADDR'];
        $message .= "\n\nVoici un lien pour vous connecter: ".$home."/inc/mammut_login.php?user=".$recover."&key=".$key;
        $message .= "\n\n\n A bientôt!\nL'équipe naät";
        $headers = 'From: recovering@naat-isn.000webhostapp.com' . "\r\n" .
        'Reply-To: support@naat-isn.000webhostapp.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
        mail($mail, $subject, $message, $headers);
        $home = "http://".$_SERVER['HTTP_HOST'].str_replace("/inc/mammut_login.php","",$_SERVER['SCRIPT_NAME']);
        echo "
            <html>
                <head>
                    <meta charset='UTF-8' />
                    <title>mot de passe oublié</title>
                    ".$style."
                </head>
                <body>
                    <script>if(confirm('Un lien vous a été envoyé par mail')){window.location = '".$home."';}</script>
                </body>
            </html>
        ";
    }
    else{
        echo "
            <html>
                <head>
                    <meta charset='UTF-8' />
                    <title>mot de passe oublié</title>
                    ".$style."
                </head>
                <body>
                    <p>Cet identifiant n'est pas accessible</p>
                    <a href='".$home."'>Retour</a>
                </body>
            </html>
        ";
    }
}else{
    echo "
        <html>
            <head>
                <meta charset='UTF-8' />
                <title>mot de passe oublié</title>
                ".$style."
            </head>
            <body>
                <p>Cet identifiant n'est pas conforme</p>
                <a href='".$home."'>Retour</a>
            </body>
        </html>
    ";
}
if(isset($_GET['user']) AND isset($_GET['key'])) {
    if(!empty($_GET['user']) AND !empty($_GET['key'])) {
        if(ctype_alpha($_GET['user']) AND ctype_alnum($_GET['key'])) {
            $user = $_GET['user'];
            $key = $_GET['key'];
            $key_ = intval($data_access->get_($data_access->user_block($user), $user, 'verification_mdp'));
            if($key == $key_) {
                $mdp = rand(rand(123456789, 987654321), rand(12345678999, 98765432100));
                $data_access->set_($data_access->user_block($user), $user, "key", $data_access->returncoded($mdp), True);
                $data_access->set_($data_access->user_block($user), $user, "verification_mdp", '', True);
                echo "
                    <html>
                        <head>
                            <meta charset='UTF-8' />
                            <title>mot de passe oublié</title>
                            ".$style."
                        </head>
                        <body>
                            <p>Voici votre nouveau mot de passe: <b>".$mdp."</b> notez le bien (ou copier collé) et pensez à le modifier juste après !</p>
                            <a href='".$home."/?login_form'>Continuer (".$home.") se connecter</a> le mot de passe indiqué précedemment vous sera demandé!
                        </body>
                    </html>
                ";
            }
            else{
                echo "
                    <html>
                        <head>
                            <meta charset='UTF-8' />
                            <title>mot de passe oublié</title>
                            ".$style."
                        </head>
                        <body>
                            <p>Ce code n'est plus valide!</p>
                            <a href='".$home."/?login_form'>Retour (".$home.")</a>
                        </body>
                    </html>
                ";
            }
        }
        else{
            echo "error";
        }
    }
}