<?php
/**
* Class data_access
* La classe qui gêre les accès aux données
* @package  Naat_ISN
* @author   Florian Hourdin <florian.hourdin59300@gmail.com>
* @author   Efekan Gocer <adam@example.com>
* @author   Thomas Lepillez
* @version  $Revision: 1.3 $
*/

Class data_access {
    
    public function __construct($dir = "") {
        if(!empty($dir)) {
            chdir($dir);
        }
    }
    
    /**
     * user_block
     * La fonction qui donne le data block
     *
     * @param mixed $USERNAME
     * @param mixed $USE_CACHE
     * @return string
     */
	public function user_block($USERNAME, $USE_CACHE = 'CACHE') {
        $USERNAME = strtolower($USERNAME);
        if($USE_CACHE == 'NO_CACHE') {
            $db = new SQLite3('./MNT_DB/userlist.db');
            $db->busyTimeout(10000);
            $db_block = $db->query('SELECT DB_BLOCK FROM USERS WHERE USERNAME = "'.$USERNAME.'"')->fetchArray()['DB_BLOCK'];
            return $db_block;   
        }
        else{
            $identifiant = str_split($USERNAME, 2);
            $sauvegarde = '';
            foreach ($identifiant as $key => $value) {
                $sauvegarde .= "/".$value;
                if(!is_dir("./MNT_DB/CACHE/data_blocks".$sauvegarde."/")){
                    mkdir("./MNT_DB/CACHE/data_blocks".$sauvegarde."/", 0777);
                }
            }
            if(file_exists('./MNT_DB/CACHE/data_blocks'.$sauvegarde.'/block_id')) {
                $get_contents_db_block = file_get_contents('./MNT_DB/CACHE/data_blocks'.$sauvegarde.'/block_id');
                if(!empty($get_contents_db_block)) {
                    return $get_contents_db_block;   
                }
                else{
                    $error_get_contents_db_block = True;
                }
            }
            else{
                $error_get_contents_db_block = True;
            }
            if(isset($error_get_contents_db_block)){
                $db = new SQLite3('./MNT_DB/userlist.db');
                $db->busyTimeout(10000);
                $db_block = $db->query('SELECT DB_BLOCK FROM USERS WHERE USERNAME = "'.$USERNAME.'"')->fetchArray()['DB_BLOCK'];
                $fp = fopen('./MNT_DB/CACHE/data_blocks'.$sauvegarde.'/block_id', "a+");
                fputs($fp, $db_block);
                fclose($fp);
                return $db_block;
            }
        }
	}
    
    /**
     * user_path
     * La fonction qui donne le path pour un username
     *
     * @param mixed $USERNAME
     * @param mixed $CACHE
     * @return string
     */
	public function user_path($USERNAME, $CACHE = 'CACHE') {
		$identifiant = str_split($USERNAME, 2);
		$sauvegarde = '';
		foreach ($identifiant as $key => $value) {
			$sauvegarde .= "/".$value;
		}
		return $sauvegarde;
	}
    
    /**
     * user_path_with_block
     * La fonction qui donne le path avec le data block pour un username
     *
     * @param mixed $USERNAME
     * @return string
     */
	public function user_path_with_block($USERNAME) {
        $db = new SQLite3('./MNT_DB/userlist.db');
        $db->busyTimeout(10000);
        $db_block = $db->query('SELECT DB_BLOCK FROM USERS WHERE USERNAME = "'.$USERNAME.'"')->fetchArray()['DB_BLOCK'];
		$identifiant = str_split($USERNAME, 2);
		$sauvegarde = '';
		foreach ($identifiant as $key => $value) {
			$sauvegarde .= "/".$value;
		}
		return $db_block.$sauvegarde;
	}
    
    /**
     * get_
     * La fonction qui permet de récupérer une valeur
     *
     * @param mixed $data_block
     * @param mixed $identifiant_
     * @param mixed $nom_valeur
     * @return string
     */
    public function get_($data_block, $identifiant_, $nom_valeur) {
		$identifiant = str_split($identifiant_, 2);
		$sauvegarde = '';
		foreach ($identifiant as $key => $value) {
			$sauvegarde .= "/".$value;
		}
		if(file_exists("./MNT_DB/".$data_block."/".$sauvegarde."/".$nom_valeur)){
			$fp = file_get_contents("./MNT_DB/".$data_block."/".$sauvegarde."/".$nom_valeur, "r");
			return $fp;
		}
		else{
			return False;
		}
	}
    
    
    /**
     * set_
     * La fonction qui permet de définir une valeur
     *
     * @param mixed $data_block
     * @param mixed $identifiant
     * @param mixed $nom_valeur
     * @param mixed $valeurs
     * @param mixed $modification
     * @return void
     */
    public function set_($data_block, $identifiant, $nom_valeur, $valeurs, $modification = False) {
		$identifiant = str_split($identifiant, 2);
		$sauvegarde = '';
		foreach ($identifiant as $key => $value) {
			$sauvegarde .= "/".$value;
			if(!is_dir("./MNT_DB/".$data_block."/".$sauvegarde."/")){
				mkdir("./MNT_DB/".$data_block."/".$sauvegarde."/", 0777);
			}
		}
		if(file_exists("./MNT_DB/".$data_block."/".$sauvegarde."/".$nom_valeur) AND $modification != True){
			return False;
		}
		else{
			if($modification == True){
				@unlink("./MNT_DB/".$data_block."/".$sauvegarde."/".$nom_valeur);
			}
			$fp = fopen("./MNT_DB/".$data_block."/".$sauvegarde."/".$nom_valeur, "a+");
			if(fputs($fp, $valeurs)) {
                return True;
            }
			fclose($fp);
		}
	}
    
    /**
     * returncoded
     * La fonction qui hashe une donnée
     *
     * @param mixed $value
     * @return string
     */
	public function returncoded($value) {
		return hash("sha512", "likeahero".$value);
    }
}

$data_access = new data_access();