<?php
include_once("menu.php");
include_once("basic_functions.php");

$link = mysqli_connect("127.0.0.1", "zelenk11", "Mor92Bud", "zelenk11");
mysqli_set_charset($link, "utf8");

if (isset($_GET['menu'])) {
    if ($_GET['menu'] == 'autori') {
        include_once("autori.php");
    } elseif ($_GET['menu'] == 'clanky') {
        if (isset($_GET['c'])) {
            include_once("clanek.php");
        } else {
            include_once("clanky.php");
        }
    } elseif ($_GET['menu'] == 'casopis') {
        include_once("casopis.php");
    } elseif ($_GET['menu'] == 'nastaveni') {
        include_once("nastaveni.php");
    }
} else {
    echo "Vítejte ve správě příspěvků časopisu Logos Polytechnikos.";
}
 ?>
