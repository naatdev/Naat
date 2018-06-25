<?php
/*
     Cette class traite les requêtes pour la connexion
*/
Class login extends naat {
    public function __construct() {
    }
    /*
        Module principal de la page
    */
    public function main() {
        /*
            Cette page n'est pas accessible si on est connecté
        */
        $this->disallowLoged();
        
        /*
            On rajoute les headers HTTP avant que du contenu soit envoyé
        */
            /*
                On traite le formulaire de connexion s'il est validé
            */
            if(isset($_POST['login'])) {
                $subs = new subs();
                $_SESSION['returnLogin'] = $subs->userLog();
            }

            /*
                On traite le formulaire d'inscription s'il est validé
            */
            if(isset($_POST['register'])) {
                $subs = new subs();
                $_SESSION['returnRegister'] = $subs->userAdd();
            }
        
        /*
            On charge la template haut -et le middle_jumbo
        */
        $this->templateLoad("notloged.top");
        
        /*
            On charge la vue du formulaire login si il est demandé
        */
        if(isset($_GET['login_form'])) {
            $this->viewLoad("forms/login_form");   
        }
        
        /*
            On charge la vue du formulaire d'inscription si il est demandé
        */
        if(isset($_GET['register_form'])) {
            $this->viewLoad("forms/register_form");   
        }
        
        /*
            On charge la template bas
        */
        $this->templateLoad("notloged.bottom");
    }
}