<?php
/*                                                                                                               
                    _              _           
                   | |            (_)          
  _ __   __ _  __ _| |_   ______   _ ___ _ __  
 | '_ \ / _` |/ _` | __| |______| | / __| '_ \ 
 | | | | (_| | (_| | |_           | \__ \ | | |
 |_| |_|\__,_|\__,_|\__|          |_|___/_| |_|
                                               
* @package  Naat_ISN
* @author   Florian Hourdin
* @author   Efekan Gocer
* @author   Thomas Lepillez
* @version  $Revision: 1.3 $                                                                                                                                                                              
*/

/*
    Mesure du temps d'execution de la page
*/
$startTime = microtime(true);

/*
    Démarrage d'une OB,
    Servira nottament à la traduction grâce à la fonction de rappel
*/
function minifier_html($contenu){
    return preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$contenu));
}
ob_start();

/*
    On définit le charset sur utf-8 et on crée la session PHP
*/
header('Content-Type: text/html; charset=utf-8');
session_start();

/*
    Options de dev:
*/

error_reporting(E_ALL);
ini_set('display_errors', 1);

/*
    On permet l'instanciation des librairies
*/
spl_autoload_register(function($class_name) {
    require_once 'app/libs/' . $class_name . '.lib.php';
});

/*
    On nettoie les images temporaires créent par un user logué lors de la dernière requête
*/
if(isset($_SESSION['userName']) AND rand(1,10) == 10) {
    $tempFileClean = new tempSecureImage();
    $tempFileClean->clearTempPic();
}

/**
* Class Naat
* On définit la classe principale naat
* @package  Naat_ISN
* @author   Florian Hourdin <florian.hourdin59300@gmail.com>
* @author   Efekan Gocer <adam@example.com>
* @author   Thomas Lepillez
* @version  $Revision: 1.3 $
*/

Class Naat {
    /*
        Quelques variables utilisées par les fonctions de la classe
    */
    /**
     * $path
     *
     * @var string
     */
    public $path;
    /**
     * $request
     *
     * @var string
     */
    public $request;
    /**
     * $home
     *
     * @var string
     */
    public $home;
    /**
     * $user_state
     *
     * @var array
     */
    public $user_state;
    
    /**
     * __construct
     * Fonction appellée lors de l'instanciation de la classe
     *
     * @param mixed $path
     * @return void
     */
    public function __construct($path = "app") {
        $this->home = $_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
        $this->path = $path;

        if(isset($_SERVER['PATH_INFO'])) {
            $this->request = substr($_SERVER['PATH_INFO'], 1);   
        }
        else{
            $this->request = '';
        }

        /*
            Déclaration des variables de session du système
        */
        $_SESSION['NAAT_ORIGIN_DIRECTORY'] = "http://".$_SERVER['HTTP_HOST'].str_replace("/index.php","",$_SERVER['SCRIPT_NAME']);
        $_SESSION['NAAT_GOTO_URL'] = $_SESSION['NAAT_ORIGIN_DIRECTORY']."/index.php/";
        $_SESSION['NAAT_HOME'] = "http://".$this->home;
        $_SESSION['NAAT_REQUEST'] = $this->request;
        if(isset($_SESSION['NAAT_PAGE_TITLE'])) {
            unset($_SESSION['NAAT_PAGE_TITLE']);
        }

        /*
            Inclusion des scripts de sécurisation
        */
        require 'inc/security/main.php';

        /*
            On enregistre le nombre de pages vues
        */
        if(file_exists('app/count_views.txt')) {
            $fileCount = fopen('app/count_views.txt', 'r+');
            $count = fgets($fileCount);
        }
        $count = $count+1;
        fseek($fileCount, 0);
        fputs($fileCount, $count);
        fclose($fileCount);
        $_SESSION['NAAT_COUNT_VIEWS'] = $count;
    }
    
    /**
     * classLoad
     * La fonction qui permet d'appeller des classes
     *
     * @param mixed $file
     * @return void
     */
    public function classLoad($file) {
        if(file_exists("./app/class/".$file.".class.php")) {
            require_once "./app/class/".$file.".class.php";
            if(class_exists($file)) {
                $class = new $file();
                $class->main();
            }
        }
        else {
            if(file_exists($this->path."/class/notfound.class.php")) {
                require_once $this->path."/class/notfound.class.php";
                if(class_exists("notfound")) {
                    $class = new notfound();
                    $class->main();
                }
            }
        }
    }
    
    /**
     * viewLoad
     * La fonction qui permet d'afficher des vues
     *
     * @param mixed $file
     * @return void
     */
    public function viewLoad($file) {
        if(file_exists("./app/views/".$file.".view.php")) {
            require_once "./app/views/".$file.".view.php";
        }
        else {
            exit("appcore: view: aucun fichier de ce nom '".$file.".view.php'");
        }
    }
    
    /**
     * libLoad
     * La fonction qui permet d'injecter des librairies de fonctions
     *
     * @param mixed $file
     * @return void
     */
    public function libLoad($file) {
        if(file_exists("./app/libs/".$file.".lib.php")) {
            require_once "./app/libs/".$file.".lib.php";
        }
        else {
            exit("appcore: libs: aucun fichier de ce nom '".$file.".lib.php'");
        }
    }

    /**
     * templateLoad
     * La fonction qui permet d'insérer des templates
     *
     * @param mixed $file
     * @return void
     */
    public function templateLoad($file) {
        if(file_exists("./inc/template/html/".$file.".html.php")) {
            require_once "./inc/template/html/".$file.".html.php";
        }
        else {
            exit("appcore: template: aucun fichier de ce nom '".$file.".html.php'");
        }
    }
    
    /**
     * main
     * La fonction principale de la classe qui reçoit les requetes
     *
     * @return void
     */
    public function main() {
        if(!empty($this->request)) {
            $this->classLoad($this->request);   
        }
        else {
            if(file_exists($this->path."/class/login.class.php")) {
                require_once $this->path."/class/login.class.php";
            }
            if(class_exists("login")) {
                $class = new login();
                $class->main();
            }
        }
    }
    
    /**
     * disallowLoged
     * La fonction qui redirige les utilisateur connectés
     *
     * @return void
     */
    public function disallowLoged() {
        if(!empty($_SESSION['userName'])) {
            Header('Location: '.$_SESSION['NAAT_GOTO_URL'].'dash');
            exit();
        }
    }
    
    /**
     * disallowNotLoged
     * La fonction qui redirige les utilisateur non connectés
     *
     * @return void
     */
    public function disallowNotLoged() {
        if(empty($_SESSION['userName'])) {
            Header('Location: '.$_SESSION['NAAT_GOTO_URL'].'login');
            exit();
        }
    }
}

/*
    On instancie la classe précédemment définie (le code se trouve dans le dossier app/ on le spécifie dans les arguments)
*/
$naat = new Naat("app");

/*
    On démarre la classe principale
    A cet instant le contenu de la page est généré
*/
$naat->main();

/*
    Mesure du temps d'execution de la page
*/
$endTime = microtime(true);

/*
    Affichage du temps d'execution et de la mémoire utilisée
    Enlever cette ligne en prod
*/
    $unities = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');
echo '<!-- Temps d\'execution: '.round($endTime-$startTime, 3).'s avec '.round(memory_get_usage(True)/pow(1024,($i=floor(log(memory_get_usage(True),1024)))),2).$unities[$i].' de ram -->';

ob_end_flush();