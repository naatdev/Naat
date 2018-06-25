<?php
/**
* Class templatePost
* On définit la classe qui va génére des template de posts
* @package  Naat_ISN
* @author   Florian Hourdin <florian.hourdin59300@gmail.com>
* @author   Efekan Gocer <adam@example.com>
* @author   Thomas Lepillez
* @version  $Revision: 1.3 $
*/
Class templatePost {
    
    public function __construct() {

	}
    
    static public function dispDate($date) {
        $months = array(
            "01" => "janvier",
            "02" => "février",
            "03" => "mars",
            "04" => "avril",
            "05" => "mai",
            "06" => "juin",
            "07" => "juillet",
            "08" => "aout",
            "09" => "septembre",
            "10" => "octobre",
            "11" => "novembre",
            "12" => "décembre"
        );
        
        $date_veille = strftime("%d-%m-%Y", mktime(0, 0, 0, date('m'), date('d')-1, date('y'))); 
        $return = "";
        if(date("d-m-Y", $date) == date("d-m-Y")) {
            if(date("H")-date("H", $date) < 6) {
                $post_date = date("H")-date("H", $date);

                    if($post_date < 1) {
                        $post_date = date("i")-date("i", $date);
                        if($post_date > 0) {
                            $s = $post_date < 2 ? "" : "s";
                            $return .= "Il y a ".$post_date." minute".$s;
                        }
                        else{
                            $return .= "Il y a quelques instants";
                        }
                    }
                    else{
                        if($post_date == 1) {
                            if(date("i") < date("i", $date) AND date("H", $date) == (date("H")-1)) {
                                $post_date = date("i")+60-date("i", $date);
                                $s = $post_date < 2 ? "" : "s";
                                $return .= "Il y a ".$post_date." minute".$s;
                            }
                            else{
                                $return .= "Il y a une heure<br />";
                                $return .= date("H:i", $date);
                            }
                        }
                        else {
                            $s = $post_date < 2 ? "" : "s";
                            $return .= "Il y a ".$post_date." heure".$s."<br />";
                            $return .= date("H:i", $date);
                        }
                    }
                
            }
            else{
                $return .= 'Aujourd\'hui '.date("à H:i", $date);
            }
        }
        elseif(date("d-m-Y", $date) == $date_veille) {
            $return .= 'Hier '.date("à H:i", $date);
        }
        else{
                $return .=  date("d", $date)." ".$months[date("m", $date)]." "; if(date("Y", $date) != date("Y")) { echo date("Y", $date); }
                $return .= date("à H:i", $date);
        }
        
        return $return;
    } 
    
    static public function post($user, $real_name, $post_id, $small_avatar_url, $title, $content, $date, $editable = False, $app_url, $plus = False, $nbr_plus = False, $comments = False) {
        
        $str_edit = "<br /><br />Options<br /><br />";
        
        if($editable == True) {
            $str_edit .= '
                    <a href="'.$app_url.'edit_post?post_id='.$post_id.'">Editer</a><br />
            ';
        }
        else{
            $str_edit .= '<a href="'.$app_url.'signalement?post_user='.$user.'&post_id='.$post_id.'">Signaler</a><br />';
        }
        $brifneeded = '';
        if(strlen($title) > 0) {
            $brifneeded = '<br /><br />';
        }
        $str_plus = '';
        if($plus == True OR $comments == True) {
            $str_plus .= '<p class="post-plus">';
        }
        if($plus == True) {
            if(isset($_GET['DATE'])) {
                $date_url = '&DATE='.$_GET['DATE'];
            }
            else{
                $date_url = '';
            }
            $str_plus .= '<a href="'.$_SESSION['NAAT_GOTO_URL'].'profile?profile_id='.$user.$date_url.'&add_plus&post_id='.$post_id.'">Plus 1 <img src="'.$_SESSION['NAAT_ORIGIN_DIRECTORY'].'/inc/template/icons/svg/like-1.svg" class="emojis" /></a>';
            if($nbr_plus != False) {
                $str_plus .= '<span class="badge_count">'.$nbr_plus.'</span>';
            }
        }
        if($comments == True) {
            $str_plus .= '<button class="post-comment" onclick="comment(\''.$user.'\',\''.$post_id.'\');">Laisser un commentaire...</button>';
        }
        if($plus == True OR $comments == True) {
            $str_plus .= '</p>';
        }
        
        $template = '
        
            <div class="col col-lg-10 post">
                <div class="row">
                    <div class="col col-lg-3">
                        <div class="row">
                            <div class="col col-lg-3">
                                <div class="small_circle_avatar" style="background-image: url(\''.$small_avatar_url.'\');"></div>
                            </div>
                            <div class="col col-lg-7">
                                <span class="post-author">
                                    '.$real_name.'
                                    <br />
                                    <a href="'.$app_url.'profile?profile_id='.$user.'">@'.$user.'</a>
                                </span>
                            </div>
                            <div class="col col-padding col-lg-10">
                                <span class="post-date">
                                    '.templatePost::dispDate($date).'
                                </span>
                                '.$str_edit.'
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="col col-lg-7">
                        <span class="post-title">
                            <a name="post_id_'.$post_id.'">'.$title.'</a>
                        </span>
                        '.$brifneeded.'
                        <span class="post-content">
                            '.$content.'
                        </span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="row">
                    <div class="col col-lg-3"></div>
                    <div class="col col-lg-7">
                        '.$str_plus.'
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        ';
        
        return $template;
    }
    
}