<?php
/**
* Class dash
* Cette class traite les requêtes pour le dashboard
* @package  Naat_ISN
* @author   Florian Hourdin <florian.hourdin59300@gmail.com>
* @version  $Revision: 1.3 $
*/
Class dash extends naat {
    /**
     * __construct
     * Fonction appellée lors de l'instanciation de la classe
     *
     * @return void
     */
    public function __construct() {
        /*
            Cette page n'est pas autorisé aux visiteurs non logués
        */
        $this->disallowNotLoged();
        /*
            Cette page reçoit les requêtes de déconnexion
        */
        if(isset($_GET['logout'])) {
            if(isset($_GET['token']) AND $_GET['token'] == $_SESSION['token']) {
                session_destroy();
                header("Location: ".$_SESSION['NAAT_GOTO_URL']."login");
                exit();
            }
        }
    }
    /**
     * main
     * Module principal de la page
     *
     * @return void
     */
    public function main() {        
        /*
            On charge la template haut
        */
        $this->templateLoad("loged.top");

        /*
            On charge la vue dashboard
        */
        //$this->viewLoad("dashboard");
        if(isset($_GET['new_post'])) {
            $this->viewLoad("dash/write");
        }
        $groups = array("posts","write","recommends","following");
        if(isset($_GET['group']) AND in_array($_GET['group'], $groups)) {
            $this->viewLoad("dash/".$_GET['group']);
        }
        else{
            $this->viewLoad("dash/posts");
        }
        
        /*
            On charge la template bas
        */
        $this->templateLoad("loged.bottom");
    }
}