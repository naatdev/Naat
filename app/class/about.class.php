<?php
/*
     Cette class traite les requêtes pour la page à propos
*/
Class about extends naat {
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
        $this->viewLoad("about");
        
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