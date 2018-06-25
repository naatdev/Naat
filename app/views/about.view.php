<?php if(isset($_SESSION['userName'])) {echo "<div id=\"page_content\">";} ?>
<div class="row">
    <div class="col col-padding col-lg-2">
        
    </div>
    <div class="col col-padding col-lg-6">
        <p class="intro_middle_jumbo">À propos</p>
    </div>
    <div class="col col-padding col-lg-2">
        
    </div>
</div>
<div class="clear"></div>
<div class="row dual_screen_presentation">
    <div class="col col-lg-1 col-sm-none">
    
    </div>
    <div class="col col-lg-4 col-sm-10">
        <a name="page_content"></a>
        <span class="col_title">L'équipe du site</span>
        <table id="about_team">
            <tr>
                <td>
                    <span><a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>profile?user=florian">Florian Hourdin</a></span>
                </td>
                <td>
                    <span>Développeur,<br />Designer</span>
                </td>
            </tr>
            <tr>
                <td>
                    <span><a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>profile?user=efekan">Efekan Gocer</a></span>
                </td>
                <td>
                    <span>Développeur</span>
                </td>
            </tr>
            <tr>
                <td>
                    <span><a href="<?php echo $_SESSION['NAAT_GOTO_URL']; ?>profile?user=thomas">Thomas Lepillez</a></span>
                </td>
                <td>
                    <span>Développeur</span>
                </td>
            </tr>
            <tr>
                <td>
                    <br />
                </td>
                <td>
                    <br />
                </td>
            </tr>
        </table>
    </div>
    <div class="col col-lg-4 col-sm-10">
        <span class="col_title">Crédits</span>
        <table id="about_team">
        </table>
    </div>
    <div class="col col-lg-1 col-sm-none">
    
    </div>
</div>
<div class="clear"></div>
<?php if(isset($_SESSION['userName'])) {echo "</div>";} ?>