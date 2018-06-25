<?php
/**
* Code pour la recherche sur le panel de droite
* On créé la réponse à afficher
* @package  Naat_ISN
* @author   Florian Hourdin <florian.hourdin59300@gmail.com>
* @version  $Revision: 1.3 $
*/
/*
    On démarre la session et on injecte les librairies nécessaires
*/
session_start();
if(!isset($_SESSION['userName'])) {
    Die("Impossible, vous n'êtes pas connecté!");
}
include_once("../../app/libs/data_access.lib.php");
include_once("../../app/libs/tempSecureImage.lib.php");
$data_access = new data_access("../../");
$tempSecureImage = new tempSecureImage();

/*
    On attend 0.5s pour que loading des resultats s'affiche quand même
*/
usleep(250000);

/*
    On vérifie qu'il y ait bien une requete de recherche et on l'encapsule
*/
if(isset($_GET['search_str']) AND !empty($_GET['search_str']) AND strlen($_GET['search_str']) < 20 AND ctype_alnum($_GET['search_str'])) {
	$searchStr = htmlspecialchars($_GET['search_str']);
}

if(isset($_GET['search_str']) AND (strlen($_GET['search_str']) > 19 OR strlen($_GET['search_str']) < 1 OR !ctype_alnum($_GET['search_str']))) {
?>
    <div class="col col-sm-10 col-lg-10">
        <p class="error">Veuillez entrer une chaine de caractéres composée d'au moins 1 et de moins de 20 caractères et de chiffres et lettres uniquement.</p>
    </div>
<?php
    $validSearch = False;
}
if(isset($searchStr) AND !isset($validSearch)) {
    $count = 0;
    $db = new SQLite3('./MNT_DB/userlist.db'); /* On se trouve au bon endroit comme on a fait un chdir avec la lib data_access */
    $db->busyTimeout(10000);
    $searchStr_ = htmlspecialchars($db->escapeString($searchStr));
    $results = $db->query('SELECT * FROM USERS WHERE "USERNAME" LIKE "%'.$searchStr_.'%" ORDER BY "ID" DESC LIMIT 20');

    while($row = $results->fetchArray()) {
        $count++;
        $block = $data_access->user_block($row['USERNAME']);
        ?>
        <div class="row">
            <div class="col col-lg-2">
                <div style="width: 45px;height:45px;border-radius:50%;background-size:cover;background-position:center center;background-image:url('<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY'].'/'.$tempSecureImage->createTempPic('./'.$data_access->get_($block, $row['USERNAME'], "small_avatar")); ?>');"></div>
            </div>
            <div class="col col-lg-7">
                <span class="small_indic"><?php echo $data_access->get_($block, $row['USERNAME'], "nom_reel"); ?></span>
                <br />
                <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>profile?profile_id=<?php echo $row['USERNAME']; ?>">@<?php echo $row['USERNAME']; ?></a>
            </div>
            <div class="col col-lg-1">
                <a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>messages?group=new&dest=<?php echo $row['USERNAME']; ?>">
                    <img src="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/icons/svg/dialogue/chat-23.svg" width="35px" style="margin-top:5px;" onclick="dispLoadingIcon('Chargement de la messagerie ...');" />
                </a>
            </div>
            <div class="col col-lg-10"><br /></div>
        </div>
        <div class="clear"></div>
        <?php
    }
    ?>
        <div class="col col-sm-10 col-lg-10">
            <?php if($count < 1) { ?>
                <p class="error">Aucun résultat pour le terme '<?php echo $searchStr_; ?>'</p>
            <?php } ?>
        </div>
    <?php
}
?>
<div class="col col-padding col-sm-10 col-lg-10">
    <br />
    <p class="info">Seuls les 20 premiers résultats sont affichés.</p>
</div>