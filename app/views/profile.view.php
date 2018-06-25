<?php
$data_access = new data_access();
$tempSecureImage = new tempSecureImage();
$emojis = new emojis();
$db = new SQLite3('MNT_DB/'.$data_access->user_block($_SESSION['userName']).$data_access->user_path($_SESSION['userName']).'/data.db');
$db->busyTimeout(10000);
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

$username = htmlspecialchars($_GET['profile_id']);
if($data_access->get_($data_access->user_block($username), $username, "username")) {
	$db = new SQLite3('MNT_DB/'.$data_access->user_block($username).'/'.$data_access->user_path($username).'/data.db');
    $db->busyTimeout(10000);
    ?>
    <div id="profile_content">
    <?php
        $this->viewLoad("profile/top-profile");
        //$this->viewLoad("profile/posts-profile");
    ?>
    </div>
    <script type="text/javascript">
      $(document).ready(function () {
          $("#onlineState").load("<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc-bin/onlineState.php?profile_id=<?php echo $username; ?>");
          var refreshId = setInterval(function () {
              $("#onlineState").load("<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc-bin/onlineState.php?profile_id=<?php echo $username; ?>");
          }, 5000);
          $.ajaxSetup({
              cache: false
          });
      });
    </script>

<?php
}
else{
    Header('Location: '.$_SESSION['NAAT_GOTO_URL'].'dash');
    exit();
}
?>