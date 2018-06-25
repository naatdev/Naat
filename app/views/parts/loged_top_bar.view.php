<?php
    $tempFile = new tempSecureImage();
    $my_avatar = $tempFile->createTempPic($_SESSION['currentUserAvatar']);
?>

<?php
function ifactive($link) {
    if($_SESSION['NAAT_REQUEST'] == $link) {
        echo " class=\"active\"";
    }
}
function ifactivepanel($name) {
    if(isset($_GET['group']) AND $_GET['group'] == $name) {
        echo " class=\"active\"";
    }
    if(!isset($_GET['group']) AND $name == "home") {
        echo " class=\"active\"";
    }
}
$stateIconMessages = "inactive";
$stateIconNotifications = "inactive";
if($_SESSION['unreadMsg'] != 0) {
    $stateIconMessages = "active";
}
?>
<div id="top_logo" class="makefix">Naät</div>
<a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>messages?refpage=<?php echo $_SESSION['NAAT_REQUEST']; ?>&uid=" id="topMessageiconLink"><img src="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/icons/topbar/message_<?php echo $stateIconMessages; ?>.png" width="25px" /></a>
<a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>notifications?refpage=<?php echo $_SESSION['NAAT_REQUEST']; ?>&uid=" id="topNotificationiconLink"><img src="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/icons/topbar/notification_<?php echo $stateIconNotifications; ?>.png" width="25px" /></a>
<div id="topbar" class="makefix">
        <div id="links">
            <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>dash?refpage=<?php echo $_SESSION['NAAT_REQUEST']; ?>&uid="<?php ifactive('dash'); ?> onclick="dispLoadingIcon();">Accueil</a>
            <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>apps?refpage=<?php echo $_SESSION['NAAT_REQUEST']; ?>&uid="<?php ifactive('apps'); ?> onclick="dispLoadingIcon();">Applications</a>
            <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>settings?refpage=<?php echo $_SESSION['NAAT_REQUEST']; ?>&uid="<?php ifactive('settings'); ?> onclick="dispLoadingIcon();">Paramètres</a>
            <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>profile?profile_id=<?php echo $_SESSION['userName']; ?>&refpage=<?php echo $_SESSION['NAAT_REQUEST']; ?>&uid="<?php ifactive('profile'); ?> onclick="dispLoadingIcon();">Mon profil</a>
            <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>about?refpage=<?php echo $_SESSION['NAAT_REQUEST']; ?>&uid="<?php ifactive('about'); ?> onclick="dispLoadingIcon();">À propos</a>
            <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>dash?logout&token=<?php echo $_SESSION['token']; ?>">Quitter &nbsp;&nbsp;<i class="fa fa-power-off"></i></a>
        </div>
        <div id="search">
            <input type="text" name="search_str" placeholder="Rechercher des personnes ..." onfocus="showSearchPanel();" onkeyup="updateSearchPanel(this.value);">
            <button type="submit"><i class="fa fa-search"></i></button>
        </div>
        <div id="small_avatar_me"></div>
</div>
<div id="subtopbar">
    <?php
        if($_SESSION['NAAT_REQUEST'] == "dash") {
    ?>
    <a href="?group=posts"<?php ifactivepanel('posts'); if(!isset($_GET['group'])) {echo " class=\"active\"";} ?> onclick="dispLoadingIcon();">Vue d'ensemble</a>
    <a href="?group=posts&new_post"<?php ifactivepanel('write'); ?> onclick="dispLoadingIcon();"><i class="fa fa-clipboard"></i>&nbsp; Nouvel article</a>
    <a href="?group=recommends"<?php ifactivepanel('recommends'); ?> onclick="dispLoadingIcon();"><i class="fa fa-star"></i>&nbsp; Recommandations</a>
    <a href="?group=following"<?php ifactivepanel('following'); ?> onclick="dispLoadingIcon();"><i class="fa fa-users"></i>&nbsp; Following</a>
    <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>edit_buble?create" onclick="dispLoadingIcon();"><i class="fa fa-user-circle"></i>&nbsp; Créer une bulle</a>
    <?php
        }
    ?>
    <?php
        if($_SESSION['NAAT_REQUEST'] == "settings") {
    ?>
    <a href="?group=home"<?php ifactivepanel('home'); ?>>Accueil</a>
    <a href="?group=profile"<?php ifactivepanel('profile'); ?>><i class="fa fa-user"></i>&nbsp; Profil</a>
    <a href="?group=pictures"<?php ifactivepanel('pictures'); ?>><i class="fa fa-camera"></i>&nbsp; Illustrations</a>
    <a href="?group=advanced"<?php ifactivepanel('advanced'); ?>><i class="fa fa-asterisk"></i>&nbsp; Avancé</a>
    <a href="?group=posts"<?php ifactivepanel('posts'); ?>><i class="fa fa-clipboard"></i>&nbsp; Posts</a>
    <a href="?group=confidentiality"<?php ifactivepanel('confidentiality'); ?>><i class="fa fa-user-secret"></i>&nbsp; Confidentialité</a>
    <?php
        }
    ?>
    <?php
        if($_SESSION['NAAT_REQUEST'] == "edit_buble") {
    ?>
    <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>" class="active">Accueil</a>
    <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>dash?group=recommends" onclick="dispLoadingIcon();"><i class="fa fa-users"></i>&nbsp; Recommandations de personnes</a>
    <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>settings?group=confidentiality"><i class="fa fa-user-secret"></i>&nbsp; Paramètres de confidentialité</a>
        <?php if(!isset($_GET['create'])) { ?><a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>view_buble?buble_id=<?php echo $_GET['buble_id']; ?>"><i class="fa fa-globe"></i>&nbsp; Ouvrir la bulle</a><?php } ?>
    <?php
        }
    ?>
    <?php
        if($_SESSION['NAAT_REQUEST'] == "view_buble") {
    ?>
    <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>" class="active">Accueil</a>
    <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>dash?group=recommends" onclick="dispLoadingIcon();"><i class="fa fa-users"></i>&nbsp; Recommandations de personnes</a>
    <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>edit_buble?buble_id=<?php echo $_GET['buble_id']; ?>"><i class="fa fa-cogs"></i>&nbsp; Paramètres de la bulle</a>
    <?php
        }
    ?>
    <?php
        if($_SESSION['NAAT_REQUEST'] == "about") {
    ?>
    <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>" class="active">Accueil</a>
    <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>legals"><i class="fa fa-user"></i>&nbsp; Mentions légales</a>
    <?php
        }
    ?>
    <?php
        if($_SESSION['NAAT_REQUEST'] == "legals") {
    ?>
    <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>" class="active">Accueil</a>
    <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>about"><i class="fa fa-user"></i>&nbsp; À propos</a>
    <?php
        }
    ?>
    <?php
        if($_SESSION['NAAT_REQUEST'] == "messages") {
    ?>
        <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>" class="inactive">Accueil</a>
        <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>messages?group=inbox"<?php if(isset($_GET['group']) AND $_GET['group'] == 'inbox' AND !isset($_GET['sent'])){ echo "class=\"active\""; } ?> onclick="dispLoadingIcon('Affichage de vos messages reçus');"><i class="fa fa-share-square"></i>&nbsp; Boite de réception</a>
        <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>messages?group=inbox&sent"<?php if(isset($_GET['sent'])){ echo "class=\"active\""; } ?> onclick="dispLoadingIcon('Affichage de vos messages envoyés');"><i class="fa fa-paper-plane"></i>&nbsp; Messages envoyés</a>
        <?php if(!isset($_GET['sent'])) { ?>
        <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>messages?group=inbox&mark_all_as_read" onclick="dispLoadingIcon('Modification des messages comme lus');"><i class="fa fa-user-tick"></i>&nbsp; Tout marquer comme lu</a>
        <?php } ?>
        <?php if(isset($_GET['group']) AND $_GET['group'] == "new") { ?>
        <a href="#" class="active">Rédaction d'un message</a>
        <?php } ?>
    <?php
        }
    ?>
    <?php
        if($_SESSION['NAAT_REQUEST'] == "edit_post") {
    ?>
    <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>dash" onclick="dispLoadingIcon();">Vue d'ensemble</a>
    <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>dash?group=write" onclick="dispLoadingIcon();"><i class="fa fa-comment"></i>&nbsp; Écrire un article</a>
    <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>settings?group=posts"><i class="fa fa-clipboard"></i>&nbsp; Posts</a>
    <a href="#" class="active">Édition d'une publication</a>
    <?php
        }
    ?>
    <?php
        if($_SESSION['NAAT_REQUEST'] == "profile") {
    ?>
    <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>dash" onclick="dispLoadingIcon();">Accueil</a>
    <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>messages?group=new&dest=<?php echo $_GET['profile_id']; ?>" onclick="dispLoadingIcon();"><i class="fa fa-comment"></i>&nbsp; Envoyer un message à @<?php echo $_GET['profile_id']; ?></a>
    <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>signalement?profile&user_id=<?php echo $_GET['profile_id']; ?>"><i class="fa fa-clipboard"></i>&nbsp; Signaler</a>
    <?php
        }
    ?>
    <?php
        if($_SESSION['NAAT_REQUEST'] == "pic_add") {
    ?>
    <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>dash" onclick="dispLoadingIcon();">Accueil</a>
    <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>gallery" onclick="dispLoadingIcon();"><i class="fa fa-camera"></i>&nbsp; Retour à la galerie</a>
    <?php
        }
    ?>
    <?php
        if($_SESSION['NAAT_REQUEST'] == "gallery") {
    ?>
    <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>dash" onclick="dispLoadingIcon();">Accueil</a>
    <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>pic_add" onclick="dispLoadingIcon();"><i class="fa fa-camera"></i>&nbsp; Ajouter une photo à la galerie</a>
    <?php
        }
    ?>
    <?php
        if($_SESSION['NAAT_REQUEST'] == "pic_view") {
    ?>
    <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>dash" onclick="dispLoadingIcon();">Accueil</a>
    <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>pic_add" onclick="dispLoadingIcon();"><i class="fa fa-camera"></i>&nbsp; Ajouter une photo à ma galerie</a>
    <?php
        }
    ?>
</div>

<div id="search_panel">
    <div class="row">
        <div class="col col-padding col-lg-10 col-sm-10">
            <span class="page_title">Résultats de la recherche</span>
            <a href="#" onclick="hideSearchPanel();">&nbsp;&nbsp;&nbsp;&nbsp;<img src="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/icons/svg/multiply.svg" class="icon" width="15px" />&nbsp;&nbsp;&nbsp;&nbsp;fermer</a>
            <br /><br />
            <span class="small_indic">Vous pouvez rechercher un membre par son identifiant</span>
        </div>
        <div class="col col-padding col-lg-10 col-sm-10" id="search_results">
        </div>
    </div>
    <div class="clear"></div>
</div>