<?php
/**
* Class edit_buble
* Cette class traite les requêtes pour modifier une bulle
* @package  Naat_ISN
* @author   Florian Hourdin <florian.hourdin59300@gmail.com>
* @version  $Revision: 1.3 $
*/
Class edit_buble extends naat {
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
            Si on demande de créer une bulle
        */
        if(isset($_GET['create'])) {
            $data_access = new data_access();
            $db = new SQLite3('MNT_DB/'.$data_access->user_block($_SESSION['userName']).$data_access->user_path($_SESSION['userName']).'/data.db');
            $db->busyTimeout(10000);
            /*
                Si on peut en créer une, on affiche la vue de création
            */
			if(intval($db->query('SELECT count("ID") as ct_id FROM listing_bubles')->fetchArray()['ct_id']) < 10) {
				$this->viewLoad("bubles/create_buble");
			}
			else{
            /*
                Sinon on redirige l'utilisateur vers un message d'erreur
            */
				sleep(1);
                Header('Location: '.$_SESSION['NAAT_GOTO_URL'].'error?error_too_many_bubles');
                Exit(); //optional
			}
        }
        /*
            Si on demande à modifier une bulle
        */
		else{
            /*
                On vérifie que l'utilisateur a spécifié la bulle a modifier
            */
			if(isset($_GET['buble_id']) AND !empty($_GET['buble_id']) AND is_numeric($_GET['buble_id'])) {
                $data_access = new data_access();
                $db = new SQLite3('MNT_DB/'.$data_access->user_block($_SESSION['userName']).$data_access->user_path($_SESSION['userName']).'/data.db');
                $db->busyTimeout(10000);
                $id = htmlspecialchars($db->escapeString($_GET['buble_id']));
                /*
                    Si la bulle existe on affiche la vue permettant de la modifier
                */
				if($db->query('SELECT count("ID") as ct_id FROM listing_bubles WHERE "ID" = "'.$id.'"')->fetchArray()['ct_id'] > 0) {
					$this->viewLoad("bubles/edit_buble");
                }
                /*
                    Si la bulle n'existe pas on le redirige vers la page d'accueil
                */
				else{
                    Header('Location: '.$_SESSION['NAAT_GOTO_URL'].'dash');
                    Exit(); //optional
				}
            }
            /*
                S'il ne dit pas quelle bulle modifier on le redirige vers la page d'accueil
            */
			else{
				Header('Location: '.$_SESSION['NAAT_GOTO_URL'].'dash');
                Exit(); //optional
			}
		}
        
        /*
            On charge la template bas
        */
        $this->templateLoad("loged.bottom");
    }
}