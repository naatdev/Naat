        </div>
        
        <div id="bottom_credits">
            <div class="row">
                <div class="col col-padding col-lg-1"></div>
                <div class="col col-padding col-lg-2">
                    <span id="top_logo">N</span> &nbsp;&nbsp; Naät &nbsp;&nbsp; <span class="authors">&copy; <?php echo date("Y"); ?></span>
                </div>
                <div class="col col-padding col-text-align-center col-lg-2">
                    <p class="links">
                        <a href="<?php echo $_SESSION['NAAT_GOTO_URL'].'legals?'.uniqid(); ?>#page_content" onclick="dispLoadingIcon();">Mentions légales</a>
                        <a href="<?php echo $_SESSION['NAAT_GOTO_URL'].'about?'.uniqid(); ?>#page_content" onclick="dispLoadingIcon();">À propos</a>
                    </p>
                </div>
                <div class="col col-padding col-text-align-right col-lg-2">
                    <span>Français FR UTF-8 (France)</span>
                </div>
                <div class="col col-padding col-text-align-center col-lg-3">
                    <span class="badge"><?php echo file_get_contents("./app/count_views.txt"); ?> visites</span>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <script type="text/javascript" src="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/js/common.js"></script>
        <script type="text/javascript">
            if(screen.width < 1200) {
                alert("ATTENTION ! Vous semblez utiliser un téléphone, le site est fait pour les ordinateurs !");
                dispSomeHelp("ATTENTION ! Vous semblez utiliser un télephone, le site est fait pour les ordinateurs !");
            }
        </script>
    </body>
</html>