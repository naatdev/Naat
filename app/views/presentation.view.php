<?php
$data_access = new data_access();
?>
<div id="presentation_register_step_2">
    <a href="<?php echo $_SESSION['NAAT_GOTO_URL'].'dash'; ?>" id="ignore_step">Ignorer cette étape</a>
    <h1>Félicitations !</h1>
    <h2>Vous êtes désormais inscrit !</h2>
    <p class="some_text">
        Voyons ensemble comment fonctionne naät et ce que vous pouvez faire dès à présent
            <br /><br />
        Sur naät vous pouvez rechercher et suivre des personnes, seuls vos nom d'utilisateur sont échangés tant que
        vous ne vous suivez pas mutuellement.
            <br />
        Chaque membre possède son profil dans lequel il est possible d'indiquer sa biographie, quelques informations
        personnelles ainsi qu'une photo de profil.
            <br />
        Vous pouvez modifier votre profil à tout moment via la page Paramètres.
            <br />
        Lorsque vous suivez des personnes vous devez les ajouter à une bulle. Vous pouvez créer jusqu'à 20 bulles 
        et elles vous permettent de trier les personnes que vous suivez selon un centre d'intérêt, le type de relation, ...
            <br />
        Chaque bulle posséde un titre et une couleur, si les paramètres de confidentialité de la personne que vous suivez 
        le permettent, vous aurez accès aux dernières publications des personnes se trouvant dans la bulle.
            <br />
        Vous pouvez à tout moment écrire des articles qui seront publiés sur votre profil et visibles par les personnes 
        autorisées qui vous suivent.
            <br />
        Pour finir, vous disposez d'une messagerie vous permettant d'intéragir avec les autres personnes sur naät.
    </p>
    <h2>N'attendez plus !</h2>
    <p class="some_text">
        Terminez de complèter votre profil et suivez des personnes que vous connaissez :)
    </p>
    <a href="<?php echo $_SESSION['NAAT_GOTO_URL'].'dash'; ?>">C'est parti !</a>
</div>