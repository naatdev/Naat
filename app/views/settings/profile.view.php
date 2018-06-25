<span class="page_title">Paramètres du profil</span>

<form method="POST" action="">
    <table id="interfaceSettingsTable">
        <tr>
            <td>
                <span>Nom et prénom</span>
            </td>
            <td>
                <input type="text" name="nom_reel" value="<?php if(!isset($_POST['nom_reel']) OR $_POST['nom_reel'] == $data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "nom_reel")) { echo $data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "nom_reel"); }else{ echo $_POST['nom_reel']; } ?>">
                <?php
                    if(isset($_POST['update']) AND !empty($_POST['nom_reel']) AND $_POST['nom_reel'] != $data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "nom_reel")) {
                        $nom_reel = $_POST['nom_reel'];
                        $db->query('INSERT INTO infos_history("NAME","VALUE","TIME","FROM_IP") VALUES("nom_reel","'.$db->escapeString($data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "nom_reel")).'","'.time().'","'.$_SERVER['REMOTE_ADDR'].'")');
                        if($data_access->set_($_SESSION['currentUserBlock'], $_SESSION['userName'], "nom_reel", $nom_reel, True)) {
                            echo "<br /><p class='success'>Enregistré</p>";
                        }else{
                            echo "<br /><p class='error'>Echec</p>";
                        }
                    }
                ?>
            </td>
            <td></td>
        </tr>
        <?php
            $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
            if(isset($_POST['update']) AND !empty($_POST['country']) AND $_POST['country'] != $data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "country")) {
                $country = $_POST['country'];
                $db->query('INSERT INTO infos_history("NAME","VALUE","TIME","FROM_IP") VALUES("country","'.$db->escapeString($data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "country")).'","'.time().'","'.$_SERVER['REMOTE_ADDR'].'")');
                if(in_array($_POST['country'], $countries) AND $data_access->set_($_SESSION['currentUserBlock'], $_SESSION['userName'], "country", $country, True)) {
                    $answercountry = "<br /><p class='success'>Enregistré</p>";
                }else{
                    $answercountry = "<br /><p class='error'>Echec</p>";
                }
            }
        ?>
        <tr>
            <td>
                <span>Pays</span>
            </td>
            <td>
                <select name="country" class="settings-select" style="width:100%;margin-bottom:20px;">
                    <option value="<?php echo $data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "country"); ?>">Actuellement: <?php echo $data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "country"); ?></option>
                    <?php
                        foreach($countries as $key => $value) {
                            ?>
                    <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                            <?php
                        }
                    ?>
                </select>
                <?php
                    if(isset($answercountry)) {
                        echo $answercountry;
                    }
                ?>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>
                <span>Ville</span>
            </td>
            <td>
                <input type="text" name="ville" value="<?php if(!isset($_POST['ville']) OR $_POST['ville'] == $data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "ville")) { echo $data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "ville"); }else{ echo $_POST['ville']; } ?>">
                <?php
                    if(isset($_POST['update']) AND !empty($_POST['ville']) AND $_POST['ville'] != $data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "ville")) {
                        $ville = $_POST['ville'];
                        $db->query('INSERT INTO infos_history("NAME","VALUE","TIME","FROM_IP") VALUES("ville","'.$db->escapeString($data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "ville")).'","'.time().'","'.$_SERVER['REMOTE_ADDR'].'")');
                        if($data_access->set_($_SESSION['currentUserBlock'], $_SESSION['userName'], "ville", $ville, True)) {
                            echo "<br /><p class='success'>Enregistré</p>";
                        }else{
                            echo "<br /><p class='error'>Echec</p>";
                        }
                    }
                ?>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>
                <span>Adresse email</span>
            </td>
            <td>
                <input type="text" name="email" value="<?php if(!isset($_POST['email']) OR $_POST['email'] == $data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "email")) { echo $data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "email"); }else{ echo $_POST['email']; } ?>">
                <?php
                    if(isset($_POST['update']) AND !empty($_POST['email']) AND $_POST['email'] != $data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "email")) {
                        $email = $_POST['email'];
                        $db->query('INSERT INTO infos_history("NAME","VALUE","TIME","FROM_IP") VALUES("email","'.$db->escapeString($data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "email")).'","'.time().'","'.$_SERVER['REMOTE_ADDR'].'")');
                        if($data_access->set_($_SESSION['currentUserBlock'], $_SESSION['userName'], "email", $email, True)) {
                            echo "<br /><p class='success'>Enregistré</p>";
                        }else{
                            echo "<br /><p class='error'>Echec</p>";
                        }
                    }
                ?>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>
                <span>Genre</span>
            </td>
            <td>
                <input type="text" name="genre" placeholder="femme, homme ou autres" onfocus="dispSomeHelp('3 valeurs possibles pour ce champs: Femme Homme ou autres');" value="<?php if(!isset($_POST['genre']) OR $_POST['genre'] == $data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "genre")) { if($data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "genre") != "Sexe non renseigné") { echo $data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "genre"); } }else{ echo $_POST['genre']; } ?>">
                <?php
                    if(isset($_POST['update']) AND !empty($_POST['genre']) AND $_POST['genre'] != $data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "genre")) {
                        $genre = $_POST['genre'];
                        $db->query('INSERT INTO infos_history("NAME","VALUE","TIME","FROM_IP") VALUES("genre","'.$db->escapeString($data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "genre")).'","'.time().'","'.$_SERVER['REMOTE_ADDR'].'")');
                        if(in_array($_POST['genre'], array('femme','homme','autres','Femme','Homme','Autres')) AND $data_access->set_($_SESSION['currentUserBlock'], $_SESSION['userName'], "genre", ucfirst($genre), True)) {
                            echo "<br /><p class='success'>Enregistré</p>";
                        }else{
                            echo "<br /><p class='error'>Echec</p>";
                        }
                    }
                ?>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>
                <span>Date de naissance</span>
            </td>
            <td>
                <input type="text" name="birthday" placeholder="jj/mm/aaaa" onfocus="dispSomeHelp('Veuillez entrer une date sous la forme jj/mm/aaaa');" value="<?php if(!isset($_POST['birthday']) OR $_POST['birthday'] == $data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "birthday")) { if($data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "birthday") != "") { echo $data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "birthday"); } }else{ echo $_POST['birthday']; } ?>">
                <?php
                    if(isset($_POST['update']) AND !empty($_POST['birthday']) AND $_POST['birthday'] != $data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "birthday")) {
                        $birthday = $_POST['birthday'];
                        $db->query('INSERT INTO infos_history("NAME","VALUE","TIME","FROM_IP") VALUES("birthday","'.$db->escapeString($data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "birthday")).'","'.time().'","'.$_SERVER['REMOTE_ADDR'].'")');
                        if(preg_match("#^[0-3][0-9]\/[0-9][0-9]\/[1-2][0-9][0-9][0-9]$#", $birthday) AND $data_access->set_($_SESSION['currentUserBlock'], $_SESSION['userName'], "birthday", $birthday, True)) {
                            echo "<br /><p class='success'>Enregistré</p>";
                        }else{
                            echo "<br /><p class='error'>Echec</p>";
                        }
                    }
                ?>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>
                <span>À propos</span>
                <br /><br />
                <p class="small_indic">
                    Il s'agit ici de la biographie affichée<br/> sur votre profil
                </p>
            </td>
            <td>
                <textarea name="presentation" rows="6" placeholder="Présentez vous"><?php if(!isset($_POST['presentation'])){echo $data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "presentation");}else{echo $_POST['presentation'];} ?></textarea>
                <?php
                    if(isset($_POST['update']) AND !empty($_POST['presentation']) AND strlen($_POST['presentation']) < 10001 AND $_POST['presentation'] != $data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "presentation")) {
                        $presentation = $_POST['presentation'];
                        $db->query('INSERT INTO infos_history("NAME","VALUE","TIME","FROM_IP") VALUES("presentation","'.$data_access->get_($_SESSION['currentUserBlock'], $_SESSION['userName'], "presentation").'","'.time().'","'.$_SERVER['REMOTE_ADDR'].'")');
                        if($data_access->set_($_SESSION['currentUserBlock'], $_SESSION['userName'], "presentation", $presentation, True)) {
                            echo "<br /><p class='success'>Enregistré</p>";
                            if($db->query('SELECT "VALUE" as ct FROM listing_infos WHERE "NAME" = "createPostForNewBio"')->fetchArray()['ct'] == 1) {
                                $db->query('INSERT INTO listing_posts("DATE","TITLE","CONTENT","TYPE","FROM_IP","PRIVACY") VALUES("'.time().'","Nouvelle biographie","'.$_POST['presentation'].'","NEW_PROFILE_BIO","'.$_SERVER['REMOTE_ADDR'].'","3")');
                            }
                        }else{
                            echo "<br /><p class='error'>Echec</p>";
                        }
                    }
                ?>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>

            </td>
            <td>
                <input type="submit" name="update" value="Mettre à jour !" class="form_input_submit_login" onclick="dispLoadingIcon('Enregistrement de vos informations ...');">
            </td>
            <td></td>
        </tr>
    </table>
</form>
<!-- FIN -->