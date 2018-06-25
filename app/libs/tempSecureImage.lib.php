<?php
/**
* Class tempSecureImage
* On définit la classe qui va créer des images temporaires
* @package  Naat_ISN
* @author   Florian Hourdin <florian.hourdin59300@gmail.com>
* @author   Efekan Gocer <adam@example.com>
* @author   Thomas Lepillez
* @version  $Revision: 1.3 $
*/
Class tempSecureImage {
    /*
    * $prefix
    *
    * @var string
    */
    public $prefix;

    /**
     * __construct
     * Constructeur de classe
     */
    public function __construct() {
        $this->prefix = 'media/pictures/profile_pics/';
    }

    /**
     * createTempPic
     * La fonction qui créer une image à lien temporaire
     *
     * @param mixed $file
     * @return string
     */
    public function createTempPic($file) {
        if(isset($_SESSION['TempPic_'.$file]) AND $_SESSION['TempPic_'.$file]['date'] > (time()-600)) {
            return $_SESSION['TempPic_'.$file]['name'];
        }
        else{
            if(isset($_SESSION['TempPic_'.$file]) AND $_SESSION['TempPic_'.$file]['date'] <= (time()-600)) {
                @unlink($_SESSION['TempPic_'.$file]['name']);
            }
            $randomed_name = uniqid();
            sleep(rand(0.0001,0.0005));
            $randomed_name .= uniqid();
            $cpfilename = $this->prefix.hash("sha1", rand(0,9999).$randomed_name).'.jpg';
            if(copy($file, $cpfilename)) {
                $_SESSION['TempPic_'.$file] = array('name' => $cpfilename, 'date' => time());
                $_SESSION['deleteTempPic'][$file] = $cpfilename;
                return $cpfilename;
            }
            else{
                return 'media/pictures/avatar.png';
            }
        }
    }

    /**
     * clearTempPic
     * La fonction qui nettoie les images temporaires créent par un user logué lors de la dernière requête
     * @return void
     */
    public function clearTempPic() {
        if(!empty($_SESSION['deleteTempPic'])) {
            foreach($_SESSION['deleteTempPic'] as $name => $value) {
                @unlink($value);
                unset($_SESSION['deleteTempPic'][$name]);
                unset($_SESSION['TempPic_'.$name]);
            }
        }
    }
}