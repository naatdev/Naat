<?php
/*
    La classe qui gère les fonctions d'inscriptions, de connexions et de mot de passes perdus
*/

Class subs {
    public $errors;
    public $datas;
    public $db;
    public $db_temp_result;
    public $MsgErrorProcess;
    
    public function __construct() {
        $this->errors = array();
        $this->datas = array();
        $this->MsgErrorProcess = "<p class='error'>Une erreur est survenue, veuillez réessayer</p>";
        $this->SucceedProcess = "<p class='success'>C'est un succés ! <a href=''>continuer >></a></p>";
    }
    
    /*
        La fonction qui permet de savoir si un username existe
    */
    public function checkUsername($username) {
        /*
            Ouverture d'une connexion à la BDD centrale
        */
        $this->db = new SQLite3('MNT_DB/userlist.db');
        $this->db->busyTimeout(10000);
        return $this->db->query('SELECT count(ID) as cnt FROM USERS WHERE username = "'.$username.'"')->fetchArray()['cnt'];
    }
    
    /*
        La fonction qui permet d'ajouter un utilisateur dans la base de données
    */
    public function userAdd() {
        $returnValue = "";
        $data_access = new data_access();
        //$returnValue .= $data_access->get_($data_access->user_block("elgringo"),"elgringo","avatar");
        /*
            D'abord on vérifie si il n'y a pas de soucis dans le formulaire
        */
        if(!isset($_POST['real_name']) OR empty($_POST['real_name'])) {
            $this->errors[] = "Veuillez indiquer un nom et prénom";
        }
        if(!isset($_POST['username']) OR empty($_POST['username'])) {
            $this->errors[] = "Veuillez indiquer un nom d'utilisateur";
        }
        else {
            if(strlen($_POST['username']) > 14 OR !ctype_alnum($_POST['username'])) {
                $this->errors[] = "Le nom d'utilisateur n'est pas conforme";
            }
        }
        if(!isset($_POST['password']) OR empty($_POST['password'])) {
            $this->errors[] = "Veuillez indiquer un mot de passe";
        }
        else {
            if(strlen($_POST['password']) < 8 OR $_POST['password'] != $_POST['password2']) {
                $this->errors[] = "Le mot de passe n'est pas conforme ou non identique à sa confirmation";
            }
        }
        if(!isset($_POST['email']) OR empty($_POST['email']) OR !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Veuillez indiquer une email valide";
        }
        /*
            Si il y a des erreurs on les affiche
        */
        if(!empty($this->errors)) {
            foreach($this->errors as $key => $value) {
                $returnValue .= "<p class='error'>".$value."</p>";
            }
        }
        /*
            Sinon on procéde à la suite
        */
        else{
            /*
                On va d'abord vérifier si le nom d'utilisateur n'est pas déjà pris
            */
            $this->datas['username'] = strtolower($_POST['username']);
            if($this->checkUsername($this->datas['username']) == 0) {
                /*
                    Le nom d'utilisateur est libre, on peut continuer
                    D'abord on va déterminer le meilleur emplacement de sauvegarde de ses données
                */
                    $regdb_db_blocks = new SQLite3('MNT_DB/db_blocks.db');
                    $regdb_db_blocks->busyTimeout(10000);
                    $db_block = $regdb_db_blocks->query('SELECT NAME as best FROM blocks ORDER BY COUNT_OF_USERS ASC LIMIT 1')->fetchArray()['best'];
                /*
                    Nous avons le meilleur emplacement, on peut sauvegarder les données
                */
                $regdb_userlist = new SQLite3('MNT_DB/userlist.db');
                $regdb_userlist->busyTimeout(10000);
                if($regdb_userlist->query('INSERT INTO USERS(USERNAME,DB_BLOCK) VALUES("'.$this->datas['username'].'","'.$db_block.'")')) {
                    /*
                        On indique qu'il y a un membre supplémentaire dans ce block de données
                    */
                    $regdb_db_blocks->query('UPDATE blocks SET COUNT_OF_USERS = COUNT_OF_USERS + 1 WHERE NAME = "'.$db_block.'"');
                    /*
                        On va créer ses fichiers de données et copier sa bdd personnelle
                    */
                    $this->datas['real_name'] = $_POST['real_name'];
                    $this->datas['password'] = $data_access->returncoded($_POST['password']);
                    $this->datas['email'] = $_POST['email'];
                    if($data_access->set_($db_block, $this->datas['username'], "nom_reel", $this->datas['real_name'], True)) {
                        if($data_access->set_($db_block, $this->datas['username'], "username", $this->datas['username'], True)) {
                            if($data_access->set_($db_block, $this->datas['username'], "key", $this->datas['password'], True)) {
                                if($data_access->set_($db_block, $this->datas['username'], "avatar", "media/pictures/avatar.png", True)) {
                                    if($data_access->set_($db_block, $this->datas['username'], "email", $this->datas['email'], True)) {
                                        @chmod("MNT_DB/".$db_block.$data_access->user_path($this->datas['username']), 0777);
                                        if($data_access->set_($db_block, $this->datas['username'], "ville", "Paris", True)) {
                                            if($data_access->set_($db_block, $this->datas['username'], "genre", "Sexe non renseigné", True)) {
                                                if($data_access->set_($db_block, $this->datas['username'], "small_avatar", "media/pictures/avatar.png", True)) {
                                                    /*
                                                        Les fichiers de données sont créés
                                                        L'utilisateur est dans la bdd centrale, on copie sa bdd personnelle
                                                    */
                                                    if(copy("MNT_DB/user.db", "MNT_DB/".$db_block.$data_access->user_path($this->datas['username'])."/data.db")) {
                                                        $db = new SQLite3('MNT_DB/'.$db_block.$data_access->user_path($this->datas['username']).'/data.db');
                                                        $db->busyTimeout(10000);
                                                        $queries = array(
                                                            'query01' => 'INSERT INTO listing_infos("NAME","VALUE") VALUES("reg_date","'.time().'")',
                                                            'query02' => 'INSERT INTO listing_infos("NAME","VALUE") VALUES("last_login","'.time().'")',
                                                            'query03' => 'INSERT INTO listing_infos("NAME","VALUE") VALUES("last_online","'.time().'")',
                                                            'query04' => 'INSERT INTO listing_infos("NAME","VALUE") VALUES("nbr_visits","0")',
                                                            'query05' => 'INSERT INTO listing_infos("NAME","VALUE") VALUES("confidentialVisibleOnline","1")',
                                                            'query06' => 'INSERT INTO listing_infos("NAME","VALUE") VALUES("confidentialVisibleEmail","0")',
                                                            'query07' => 'INSERT INTO listing_infos("NAME","VALUE") VALUES("confidentialVisibleSeen","1")',
                                                            'query08' => 'INSERT INTO listing_infos("NAME","VALUE") VALUES("confidentialVisiblePosts","1")',
                                                            'query09' => 'INSERT INTO listing_infos("NAME","VALUE") VALUES("confidentialVisibleBio","1")',
                                                            'query10' => 'INSERT INTO listing_infos("NAME","VALUE") VALUES("createPostForNewPic","1")',
                                                            'query11' => 'INSERT INTO listing_infos("NAME","VALUE") VALUES("createPostForNewBio","1")',
                                                            'query12' => 'INSERT INTO listing_infos("NAME","VALUE") VALUES("interfaceLang","fr")'  
                                                        );
                                                        $error = 0;
                                                        foreach($queries as $key => $value) {
                                                            if($db->query($value)) {

                                                            }
                                                            else{
                                                                $error = 1;
                                                            }
                                                        }
                                                        if($error == 0) {
                                                            /*
                                                                INSCRIPTION TERMINEE !
                                                                Il n'y a pas eu d'erreur tout est bon
                                                                On indique à l'utilisateur qu'il est bien inscrit
                                                            */
                                                            $_SESSION['userName'] = $this->datas['username'];
                                                            $_SESSION['first-login'] = True;
                                                            $_SESSION['currentUserBlock'] = $db_block;
                                                            $_SESSION['currentUserAvatar'] = $data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "avatar");
                                                            $_SESSION['currentUserSmallAvatar'] = $data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "small_avatar");
                                                            $_SESSION['currentUserRealName'] = $data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "nom_reel");
                                                            $_SESSION['deleteTempPic'] = array();
                                                            //$returnValue .= "<p class='success'>Vous êtes désormais inscrit, vous pouvez vous connecter ;)</p>";
                                                            /*
                                                                Les variables de session sont définies
                                                                On redirige l'utilisateur vers la page de personnalisation du profil
                                                            */
                                                            $returnValue .= $this->SucceedProcess;
                                                        }
                                                        else{
                                                            /*
                                                                Si erreur durant une requete sur la bdd personnelle
                                                            */ 
                                                            $returnValue .= $this->MsgErrorProcess;
                                                            $regdb_userlist->query('DELETE FROM USERS WHERE USERNAME="'.$this->datas['username'].'"');
                                                        }
                                                    }
                                                    else{
                                                        /*
                                                            Si erreur durantla copie de la bdd personnelle
                                                        */ 
                                                        $returnValue .= $this->MsgErrorProcess;
                                                        $regdb_userlist->query('DELETE FROM USERS WHERE USERNAME="'.$this->datas['username'].'"');
                                                    }
                                                }
                                                else{
                                                    /*
                                                        Si erreur durant l'inscription du small avatar
                                                    */ 
                                                    $returnValue .= $this->MsgErrorProcess;
                                                    $regdb_userlist->query('DELETE FROM USERS WHERE USERNAME="'.$this->datas['username'].'"');
                                                }
                                            }
                                            else{
                                                /*
                                                    Si erreur durant l'inscription du sexe
                                                */ 
                                                $returnValue .= $this->MsgErrorProcess;
                                                $regdb_userlist->query('DELETE FROM USERS WHERE USERNAME="'.$this->datas['username'].'"');
                                            }
                                        }
                                        else{
                                            /*
                                                Si erreur durant l'inscription de la ville
                                            */ 
                                            $returnValue .= $this->MsgErrorProcess;
                                            $regdb_userlist->query('DELETE FROM USERS WHERE USERNAME="'.$this->datas['username'].'"');
                                        }
                                    }
                                    else{
                                        /*
                                            Si erreur durant l'inscription de l'email
                                        */ 
                                        $returnValue .= $this->MsgErrorProcess;
                                        $regdb_userlist->query('DELETE FROM USERS WHERE USERNAME="'.$this->datas['username'].'"');
                                    }
                                }
                                else{
                                    /*
                                        Si erreur durant l'inscription de l'avatar
                                    */ 
                                    $returnValue .= $this->MsgErrorProcess;
                                    $regdb_userlist->query('DELETE FROM USERS WHERE USERNAME="'.$this->datas['username'].'"');
                                }
                            }
                            else{
                                /*
                                    Si erreur durant l'inscription du password
                                */ 
                                $returnValue .= $this->MsgErrorProcess;
                                $regdb_userlist->query('DELETE FROM USERS WHERE USERNAME="'.$this->datas['username'].'"');
                            }
                        }
                        else{
                            /*
                                Si erreur durant l'inscription de l'username
                            */ 
                            $returnValue .= $this->MsgErrorProcess;
                            $regdb_userlist->query('DELETE FROM USERS WHERE USERNAME="'.$this->datas['username'].'"');
                        }
                    }
                    else{
                        /*
                            Si erreur durant l'inscription du nom réel
                        */ 
                        $returnValue .= $this->MsgErrorProcess;
                        $regdb_userlist->query('DELETE FROM USERS WHERE USERNAME="'.$this->datas['username'].'"');
                    }
                }
                else{
                    /*
                        Si erreur durant l'inscription dans la base principale
                    */ 
                    $returnValue .= $this->MsgErrorProcess;
                }
            }
            else{
                /*
                    Cet utilisateur existe déjà, il faut changer de pseudo
                */
                $returnValue .= "<p class='error'>Ce nom d'utilisateur est déjà pris</p>";
            }
        }
        return $returnValue;
    }
    
    public function userLog() {
        $returnValue = "";
        $data_access = new data_access();
        // mb_strtolower pour input username
        if(isset($_POST['username']) AND !empty($_POST['username']) AND !empty($_POST['password'])) {
            if(!ctype_alnum($_POST['username'])) {
                $returnValue .= "<p class='error'>Mauvais format d'identifiant</p>";
            }
            else{
                $identifiant = strtolower($_POST['username']);
                $data_block = $data_access->user_block($identifiant);
                if(!empty($data_block)) {
                    if($data_access->get_($data_block, $identifiant, "key") == $data_access->returncoded($_POST['password'])) {
                        $_SESSION['userName'] = $identifiant;
                        $_SESSION['currentUserBlock'] = $data_access->user_block($_SESSION['userName']);
                        $_SESSION['currentUserAvatar'] = $data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "avatar");
                        $_SESSION['currentUserSmallAvatar'] = $data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "small_avatar");
                        $_SESSION['currentUserRealName'] = $data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "nom_reel");
                        $_SESSION['currentUserBackgroundImage'] = $data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], 'background_image');
                        $db = new SQLite3('MNT_DB/'.$data_block.$data_access->user_path($_SESSION['userName']).'/data.db');
                        $db->busyTimeout(10000);
                        $db->query('INSERT INTO login_history("DATE","FROM_IP","USER_AGENT") VALUES("'.time().'","'.$_SERVER['REMOTE_ADDR'].'","'.$_SERVER['HTTP_USER_AGENT'].'")');
                        $db->query('UPDATE listing_infos SET "VALUE" = "'.time().'" WHERE "NAME" = "last_login"');
                        sleep(1);
                        Header('Location: '.$_SERVER['PHP_SELF']);
                        Exit(); //optional
                    }
                    else{
                        $returnValue .= "<p class='error'>Mauvais identifiant ou mot de passe</p>";
                    }   
                }
                else{
                    $returnValue .= "<p class='error'>Mauvais identifiant ou mot de passe</p>";
                }
            }
        }
        if(isset($_POST['login']) AND (empty($_POST['username']) OR empty($_POST['password']))) {
            $returnValue .= "<p class='error'>Veuillez remplir les champs</p>";
        }
        return $returnValue;
    }
    
    public function userPassLost() {
        
    }
}

$subs = new subs();