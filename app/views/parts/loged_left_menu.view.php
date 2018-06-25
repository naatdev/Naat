<div id="left_menu">
    <div id="small_avatar_me"></div>
    <div id="name"><a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>profile?profile_id=<?php echo $_SESSION['userName']; ?>&refpage=dash_sidebar"><?php echo substr($_SESSION['currentUserRealName'],0,24); ?></a></div>
    <div id="username"><a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>profile?profile_id=<?php echo $_SESSION['userName']; ?>&refpage=dash_sidebar">@<?php echo $_SESSION['userName']; ?></a></div>
    <div id="links">
        <table>
            <tr>
                <td>
                    <img src="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/icons/svg/dialogue/chat-43.svg">
                </td>
                <td>
                    <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>messages?group=inbox">Messagerie&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $_SESSION['unreadMsgStr']; ?></a>
                </td>
            </tr>
            <tr>
                <td>
                    <img src="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/icons/svg/smartphone-1.svg">
                </td>
                <td>
                    <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>apps">Espace applications</a>
                </td>
            </tr>
            <tr>
                <td>
                    <img src="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/icons/svg/business/029-teamwork.svg">
                </td>
                <td>
                    <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>edit_buble?create">Créer une bulle</a>
                </td>
            </tr>
            <tr>
                <td>
                    <img src="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/icons/svg/photos.svg">
                </td>
                <td>
                    <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>gallery">Galerie photos</a>
                </td>
            </tr>
            <tr>
                <td>
                    <img src="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/icons/svg/settings-4.svg">
                </td>
                <td>
                    <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>settings">Paramètres</a>
                </td>
            </tr>
        </table>
        <!--<a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>edit_buble?create">Créer une bulle</a><br />
        <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>dash?logout&token=<?php echo $_SESSION['token']; ?>">Se déconnecter</a>-->
    </div>
    <div id="bubles_preview">
        <?php $this->viewLoad("parts/bubles_list"); ?>
    </div>
    <div id="skyscraper_pub">Votre pub ici contactez @admin (format 160*600)</div>
</div>