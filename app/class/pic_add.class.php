<?php
/**
* Class pic_add
* Cette class traite les requêtes d'ajout de photos à la gallerie
* @package  Naat_ISN
* @author   Florian Hourdin <florian.hourdin59300@gmail.com>
* @version  $Revision: 1.3 $
*/
Class pic_add extends naat {
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
            On charge la vue gallerie
        */
        $this->viewLoad("gallery/new");
        
        /*
            On charge la template bas
        */
        $this->templateLoad("loged.bottom");
    }
}