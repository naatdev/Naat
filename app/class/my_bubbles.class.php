<?php
/*
     Cette class traite les requêtes pour la liste des bulles
*/
Class my_bubbles extends naat {
    public function __construct() {
        /*
            Cette page n'est pas autorisé aux visiteurs non logués
        */
        $this->disallowNotLoged();
    }
    /*
        Module principal de la page
    */
    public function main() {
        /*
            On charge la template haut et la barre utilisateur
        */
        $this->templateLoad("loged.top");
        $this->viewLoad("parts/loged_top_bar");
        /*
            On charge le début de la vue overlay
        */
        $this->viewLoad("parts/overlay_start");
        /*
            On charge la vue dashboard
        */
        $this->viewLoad("bubbles_list");
        /*
            On charge la fin de la vue overlay
        */
        $this->viewLoad("parts/overlay_end");
        /*
            On charge la template bas
        */
        $this->templateLoad("loged.bottom");
    }
}