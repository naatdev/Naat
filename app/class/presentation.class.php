<?php
/*
     Cette class traite les requêtes pour la page de présentation
*/
Class presentation extends naat {
    public function __construct() {
        $this->disallowNotLoged();
    }
    /*
        Module principal de la page
    */
    public function main() {
        /*
            On charge la vue de présentation
        */
        $this->viewLoad("presentation");
    }
}