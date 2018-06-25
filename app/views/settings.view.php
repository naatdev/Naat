<?php
$data_access = new data_access();
$colors_lib = new giveColorFromEquivalent();
$db = new SQLite3('MNT_DB/'.$data_access->user_block($_SESSION['userName']).$data_access->user_path($_SESSION['userName']).'/data.db');
$db->busyTimeout(10000);
$groups = array("profile","pictures","advanced","posts","confidentiality");
?>
<div id="page_content">
    <div class="row">
        <div class="col col-padding col-lg-10">
            <?php
                if(!isset($_GET['group']) OR !in_array($_GET['group'], $groups)) {
                    ?>
            <span class="page_title">Paramètres du compte</span><br /><br />
            <p>Veuillez sélectionner une catégorie</p>
            <br /><br />
            <img src="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/icons/svg/business/013-presentation.svg" width="150px" />
                    <?php
                }
                if(isset($_GET['group']) AND in_array($_GET['group'], $groups)) {
                    include_once('settings/'.$_GET['group'].'.view.php');
                }
            ?>
        </div>
    </div>
    <div class="clear"></div>
</div>