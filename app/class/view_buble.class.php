<?php
/**
* Class view_buble
* Cette class traite les requêtes pour consulter une bulle
* @package  Naat_ISN
* @author   Florian Hourdin <florian.hourdin59300@gmail.com>
* @version  $Revision: 1.3 $
*/
Class view_buble extends naat {
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

        if(isset($_GET['buble_id']) AND !empty($_GET['buble_id']) AND is_numeric($_GET['buble_id'])) {
            $data_access = new data_access();
            $db = new SQLite3('MNT_DB/'.$data_access->user_block($_SESSION['userName']).$data_access->user_path($_SESSION['userName']).'/data.db');
            $db->busyTimeout(10000);
			$id = htmlspecialchars($db->escapeString($_GET['buble_id']));
			if($db->query('SELECT count("ID") as ct_id FROM listing_bubles WHERE "ID" = "'.$id.'"')->fetchArray()['ct_id'] > 0) {
			    /*
                    On charge la vue de la bulle
                */
                $this->viewLoad("bubles/view_buble");
			}
			else{
                sleep(1);
				Header('Location: '.$_SESSION['NAAT_GOTO_URL'].'dash');
                Exit(); //optional
			}
		}
		else{
            sleep(1);
			Header('Location: '.$_SESSION['NAAT_GOTO_URL'].'dash');
            Exit(); //optional
		}
        
        /*
            On charge la template bas
        */
        $this->templateLoad("loged.bottom");
    }
}