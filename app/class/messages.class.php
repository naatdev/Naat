<?php
/**
* Class messages
* Cette class traite les requêtes pour la messagerie
* @package  Naat_ISN
* @author   Florian Hourdin <florian.hourdin59300@gmail.com>
* @version  $Revision: 1.3 $
*/
Class messages extends naat {
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
            On charge la vue des messages reçus
        */
        $groups = array("inbox","view","new");
        if(!isset($_GET['group']) OR !in_array($_GET['group'], $groups) OR (isset($_GET['view']) AND !is_numeric($_GET['id']))) {
            header("Location: ".$_SESSION['NAAT_GOTO_URL']."messages?group=inbox");
            exit();
        }
        if(in_array($_GET['group'], $groups)) {
            $this->viewLoad("messages/".$_GET['group']);
        }
        else{
            $this->viewLoad("messages/inbox");
        }
        
        /*
            On charge la template bas
        */
        $this->templateLoad("loged.bottom");
    }
}