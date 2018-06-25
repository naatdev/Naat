    <?php
        if(in_array($_SESSION['NAAT_REQUEST'], array('profile','view_buble','dash'))) {
            ?>
            <div id="comment_panel">
                <iframe id="comment_panel_iframe" width="100%" height="100%" frameborder="0" src="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/comment.php"></iframe>
            </div>
            <?php
        }
    ?>
        
        <script type="text/javascript" src="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/js/jquery-3.2.1.js"></script>
        <script type="text/javascript" src="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/js/common.js"></script>
        <script type="text/javascript" src="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/js/user_space.js"></script>
        <script type="text/javascript" src="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/msgCount.php?code" id="code"></script>
        <script type="text/javascript">
            <?php include('inc/template/js/user.js.php'); ?>
        </script>
    </body>
</html>