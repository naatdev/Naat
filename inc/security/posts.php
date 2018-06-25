<?php
/*
    On sécurise tous les flux de données POST
*/
foreach($_POST as $key => $value) {
    $_POST[$key] = htmlentities($value);
}