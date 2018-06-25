<?php
/**
* Class settings
* Cette class traite les requêtes d'erreur 404
* @package  Naat_ISN
* @author   Florian Hourdin <florian.hourdin59300@gmail.com>
* @version  $Revision: 1.3 $
*/
Class notfound extends naat {
    /**
     * __construct
     * Fonction appellée lors de l'instanciation de la classe
     *
     * @return void
     */
    public function __construct() {
        
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
        if(isset($_SESSION['userName'])) {
            $this->templateLoad("loged.top");
        }
        else{
            $this->templateLoad("notloged.top");
        }
        
        /*
            On charge la vue 404
        */
        $this->viewLoad("404");
        
        /*
            On charge la template bas
        */
        if(isset($_SESSION['userName'])) {
            $this->templateLoad("loged.bottom");
        }
        else{
            $this->templateLoad("notloged.bottom");
        }
    }
}