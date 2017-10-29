<?php
include_once("menu.php");

if (isset($_GET['menu'])) {
    if ($_GET['menu'] == 'autori') {
        include_once("autori.php");
    } elseif ($_GET['menu'] == 'clanky') {
        include_once("clanky.php");
    } elseif ($_GET['menu'] == 'casopis') {
        include_once("casopis.php");
    } elseif ($_GET['menu'] == 'nastaveni') {
        include_once("nastaveni.php");
    }
}
 ?>
