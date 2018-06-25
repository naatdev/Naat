<?php
$data_access = new data_access();
$colors_lib = new giveColorFromEquivalent();
$db = new SQLite3('MNT_DB/'.$data_access->user_block($_SESSION['userName']).$data_access->user_path($_SESSION['userName']).'/data.db');
$db->busyTimeout(10000);
$nbrBubles = $db->query('SELECT count("ID") as ct_id FROM listing_bubles')->fetchArray()['ct_id'];
$results = $db->query('SELECT * FROM listing_bubles ORDER BY "ID" DESC LIMIT 20');
$count_bubles = 0;

while($row = $results->fetchArray()) {
?>
	<div class="row">
		<a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>view_buble?buble_id=<?php echo $row['ID']; ?>" onclick="dispLoadingIcon();">
			<div class="col col-lg-2 col-text-align-center">
				<div class="dash_buble_preview" style="background-color: <?php echo $colors_lib::giveFromName($row['BUBLE_COLOR']); ?>;">
					<?php echo ucfirst(substr(htmlspecialchars_decode($row['NAME']), 0, 1)); ?>
				</div>
			</div>
			<div class="col col-lg-8" style="line-height: 40px;">
				<p><?php echo substr($row['NAME'],0,20); if(strlen($row['NAME']) > 20) { echo "..."; } ?></p>
			</div>
		</a>
	</div>
	<div class="clear"></div>
<?php
}
?>
<div class="row">
	<a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>edit_buble?create" onclick="dispLoadingIcon();">
		<div class="col col-lg-2 col-text-align-center">
			<div class="dash_buble_preview" style="background-image: url('<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/icons/svg/add-2.svg');">
				&nbsp;
			</div>
		</div>
		<div class="col col-lg-8" style="line-height: 40px;">
			<p>Nouvelle</p>
		</div>
	</a>
</div>
<div class="clear"></div>
<div class="row">
    <div class="col col-padding col-lg-10">
        <span class="small_indic"><?php echo $nbrBubles; ?> bulle<?php echo $nbrBubles > 1 ? "s": ""; ?> sur 10</span>
	</div>
</div>
<div class="clear"></div>