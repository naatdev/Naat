<?php
include_once("./app/libs/tempSecureImage.lib.php");
$myPic = new tempSecureImage();
$myPic_ = $myPic->createTempPic($_SESSION['currentUserSmallAvatar']);
$background_image = $_SESSION['currentUserBackgroundImage'];
if(!empty($background_image) AND $background_image != "nothing") {
?>
body {
    background-image: url('<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/images/<?php echo $background_image; ?>');
    background-size: cover;
    background-attachment: fixed;
}
<?php
}
?>
#xsmall_avatar_me {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background-image: url('<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY'].'/'.$myPic_; ?>');
    background-position: center center;
    background-size: cover;
}

#small_avatar_me {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background-image: url('<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY'].'/'.$myPic_; ?>');
    background-position: center center;
    background-size: cover;
}

#medium_avatar_me {
    width: 85px;
    height: 85px;
    border-radius: 50%;
    background-image: url('<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY'].'/'.$myPic_; ?>');
    background-position: center center;
    background-size: cover;
}

#interfaceTopCover {
    background-image: url('<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY'].'/'.$myPic_; ?>');
}

#interfaceTopBar #full_name {
    right: <?php echo 160+(strlen($_SESSION['userName'])*7); ?>px;
}