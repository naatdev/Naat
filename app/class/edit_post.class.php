<?php
/**
* Class edit_post
* Cette class traite les requêtes pour modifier une publication
* @package  Naat_ISN
* @author   Florian Hourdin <florian.hourdin59300@gmail.com>
* @version  $Revision: 1.3 $
*/
Class edit_post extends naat {
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

        if(!isset($_GET['post_id']) OR empty($_GET['post_id']) OR strlen($_GET['post_id']) > 10 OR !is_numeric($_GET['post_id'])) {
			$this->viewLoad("404");
		}else{
			$data_access = new data_access();
            $db = new SQLite3('MNT_DB/'.$data_access->user_block($_SESSION['userName']).$data_access->user_path($_SESSION['userName']).'/data.db');
            $db->busyTimeout(10000);
			$id_post = htmlspecialchars($db->escapeString($_GET['post_id']));
			$results_count = $db->query('SELECT count(ID) as ct_ID FROM listing_posts WHERE "ID" = "'.$id_post.'"');
            $count = $results_count->fetchArray()['ct_ID'];
            $db->close();
            unset($db);
            if($count < 1) {
            	$this->viewLoad("404");
            }else{
            	$this->viewLoad("forms/edit_post");
            }
		}
        
        /*
            On charge la template bas
        */
        $this->templateLoad("loged.bottom");
    }
}