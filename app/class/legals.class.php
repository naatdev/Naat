<?php
/*
     Cette class traite les requêtes pour les mentions légales
*/
Class legals extends naat {
    public function __construct() {
    }
    /*
        Module principal de la page
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
            On charge la vue dashboard
        */
        $this->viewLoad("legals");
        
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