<?php
/**
* Class emojis
* La classe qui gêre les emojis
* @package  Naat_ISN
* @author   Florian Hourdin <florian.hourdin59300@gmail.com>
* @author   Efekan Gocer <adam@example.com>
* @author   Thomas Lepillez
* @version  $Revision: 1.3 $
*/

Class emojis {
    /*
    * $emojis
    *
    * @var array
    */
    public $emojis;
    /*
    * $path
    *
    * @var string
    */
    public $path;

    public function __construct() {
        /*
        * La liste des emojis et le dossier où ils sont
        */
        $this->emojis = array(
            ':)' => 'emojis/happy.svg',
            ':poop:' => 'emojis/010-poo.svg',
            ':p' => 'emojis/tongue-out-1.svg',
            '=D' => 'emojis/happy-1.svg',
            ':D' => 'emojis/happy-1.svg',
            ':(' => 'emojis/sad.svg',
            ':\'(' => 'emojis/unhappy.svg',
            ':o' => 'emojis/surprised.svg',
            ':kiss:' => 'emojis/kissing.svg',
            '*_*' => 'emojis/in-love.svg',
            ':|' => 'emojis/confused.svg',
            ':+)' => 'emojis/happy-2.svg',
            ';)' => 'emojis/wink.svg',
            ':~' => 'emojis/confused-1.svg',
            ':|' => 'emojis/confused.svg',
            'O_o' => 'emojis/surprised-1.svg',
            ':haha:' => 'emojis/084-laughing.svg',
            ':ange:' => 'emojis/048-angel.svg',
            ':singe-1:' => 'emojis/016-monkey.svg',
            ':singe-2:' => 'emojis/015-monkey-1.svg',
            ':singe-3:' => 'emojis/014-monkey-2.svg',
            ':cupid:' => 'emojis/099-cupid.svg',
            ':coeur-7:' => 'emojis/103-heart-7.svg',
            ':couronne:' => 'emojis/137-crown.svg',
            ':star:' => 'business/033-award.svg',
            ':money:' => 'business/012-money-bag.svg',
            ':text:' => 'dialogue/envelope-6.svg'
        );
        $this->path = $_SESSION['NAAT_ORIGIN_DIRECTORY']."/inc/template/icons/svg/";
    }
    
    /**
     * transformToSvg
     * La fonction qui remplace les codes par les emojis en svg
     *
     * @param mixed $input
     * @return string
     */
    function transformToSvg($input) {
        foreach($this->emojis as $key => $value) {
            $input = str_replace(' '.$key, ' <img src="'.$this->path.$value.'" class="emojis" /> ', $input);
        }
        return $input;
    }

    /**
     * emojisList
     * La fonction qui donne la liste des emojis en svg
     *
     * @return string
     */
    function emojisList() {
        return $this->emojis;
    }

    /**
     * emojisLink
     * La fonction qui donne le lien d'un emojis en svg
     *
     * @param mixed $input
     * @return string
     */
    function emojisLink($input) {
        return $this->path.$this->emojis[$input];
    }
}