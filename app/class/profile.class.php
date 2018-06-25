<?php
/**
* Class profile
* Cette class traite les requêtes pour le profile
* @package  Naat_ISN
* @author   Florian Hourdin <florian.hourdin59300@gmail.com>
* @version  $Revision: 1.3 $
*/
Class profile extends naat {
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
        if(isset($_GET['profile_id'])) {
			if(empty($_GET['profile_id']) OR !ctype_alnum($_GET['profile_id']) OR strlen($_GET['profile_id']) > 15) {
				Header('Location: '.$_SESSION['NAAT_GOTO_URL'].'dash');
                exit();
			}
			else{
				$this->viewLoad("profile");
			}
		}
		else{
			Header('Location: '.$_SESSION['NAAT_GOTO_URL'].'dash');
            exit();
		}
        
        /*
            On charge la template bas
        */
        $this->templateLoad("loged.bottom");
    }
}