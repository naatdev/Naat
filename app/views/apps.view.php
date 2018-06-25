<div id="container_store"></div>
<div id="page_content_store">
    <span class="page_title">Bibliothèque d'applications</span>
    <div class="row">
        <div class="col col-lg-2 menu">
            <a href="#jeux">Jeux</a><br />
            <a href="#outils">Outils</a><br />
            <a href="#développeur">Développeur</a><br />
        </div>
        <div class="col col-lg-8">
            <div class="row liste">
                <div class="col col-lg-10">    
                    <a name="jeux" class="section">Jeux</a><br />
                </div>
                <div class="col app-preview" onclick="playApp('deathtrial');" style="background-image:url('<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/webapps/deathtrial/logo.png');">
                    
                </div>
                <div class="col app-preview" onclick="playApp('qcm');" style="background-image:url('<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/webapps/qcm/logo.png');">
                    
                </div>
                <div class="col col-lg-10">    
                    <br /><br />
                </div>
            </div>
            <div class="clear"></div>

            <div class="row liste">
                <div class="col col-lg-10">
                    <a name="outils" class="section">Outils</a><br />
                </div>
                <div class="col col-lg-10">    
                    <br /><br />
                </div>
            </div>
            <div class="clear"></div>

            <div class="row liste">
                <div class="col col-lg-10">
                    <a name="développeur" class="section">Développeur</a><br />
                </div>
                <div class="col col-lg-10">    
                    <br /><br />
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<script type="text/javascript">
function playApp(name) {
    open('<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/webapps/'+name+'/app/index.html', 'Jeu ' + name, 'scrollbars=0,resizable=0'); return false;
}
</script>