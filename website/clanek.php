<?php
if (isset($_POST['prijmout_k_recenzi'])) {
    $query_schvalit = "UPDATE rsp_autori SET schvaleno='1' WHERE index='".$_GET['c']."'";
    $sql = mysqli_query($link, $query_schvalit);
}
if (isset($_POST['zamitnout_k_recenzi'])) {
    $query_zamitnout = "UPDATE rsp_autori SET schvaleno='0' WHERE index='".$_GET['c']."'";
    $sql = mysqli_query($link, $query_zamitnout);
}
if (isset($_POST['posudek_1_submit'])) {
    $query_posudek_1 = "UPDATE rsp_autori SET posudek_1='".$_POST['posudek_1']."' WHERE index='".$_GET['c']."'";
    $sql = mysqli_query($link, $query_posudek_1);
}
if (isset($_POST['posudek_1_submit'])) {
    $query_posudek_2 = "UPDATE rsp_autori SET posudek_2='".$_POST['posudek_2']."' WHERE index='".$_GET['c']."'";
    $sql = mysqli_query($link, $query_posudek_2);
} if (isset($_POST['odemknout_opravu'])) {
    $query_oprava = "UPDATE rsp_autori SET oprava='0' WHERE index='".$_GET['c']."'";
    $sql = mysqli_query($link, $query_oprava);
}

$query_load_clanky = "SELECT * FROM rsp_autori NATURAL JOIN rsp_casopisy WHERE rsp_autori.index = '".$_GET['c']."';";
$sql_clanky = mysqli_query($link, $query_load_clanky);

$sql_clanky_assoc = mysqli_fetch_array($sql_clanky, MYSQLI_ASSOC);
// echo "<pre>"; print_r($sql_clanky_assoc); echo "</pre>";

$query_num_clanky = "SELECT * FROM rsp_casopisy NATURAL JOIN rsp_autori WHERE cislo = '".$sql_clanky_assoc['cislo']."' AND prijato = '1';";
$sql_num_clanky = mysqli_query($link, $query_num_clanky);
$clanky_num = mysqli_num_rows($sql_num_clanky);
?>

<table class="table">
    <tr>
        <td>Jméno autora</td>
        <td><?php echo $sql_clanky_assoc['autor_name']; ?></td>
    </tr>
    <tr>
        <td>E-mail</td>
        <td><?php echo $sql_clanky_assoc['autor_mail']; ?></td>
    </tr>
    <tr>
        <td>Číslo časopisu</td>
        <td><?php echo $sql_clanky_assoc['rok']."/".$sql_clanky_assoc['ctvrtleti']; ?></td>
    </tr>
    <tr>
        <td>Téma časopisu</td>
        <td><?php echo $sql_clanky_assoc['tema']; ?></td>
    </tr>
    <tr>
        <td>Kapacita</td>
        <td><?php echo $clanky_num."/".$sql_clanky_assoc['kapacita']; ?></td>
    </tr>
    <tr>
        <td>E-mail</td>
        <td></td>
    </tr>
</table>

<embed src="http://195.113.207.171/~zelenk11/rsp/uploads/<?php echo $sql_clanky_assoc['index']; ?>.pdf" width="990" height="700" type='application/pdf'></embed>

<form method="post">
    <table class="table">
        <?php if ($_SESSION['adm'] == 1 || $_SESSION['red'] == 1) : ?>
            <tr>
                <td>Přijmout do recenzního řízení</td>
                <td>
                    <?php if ($sql_clanky_assoc['schvaleno'] == -1) : ?>
                        <input type="submit" name="prijmout_k_recenzi" value="Přijmout"><input type="submit" name="zamitnout_k_recenzi" value="Zamítnout">
                    <?php else: echo BitToText($sql_clanky_assoc['schvaleno']);
                          endif; ?>
                </td>
            </tr>
        <?php endif;
        if ($sql_clanky_assoc['schvaleno'] == 1 && ($_SESSION['adm'] == 1 || $_SESSION['rec'] == 1)) : ?>
            <tr>
                <td>Posudek 1</td>
                <td>
                    <?php if ($sql_clanky_assoc['posudek_1'] == "") : ?>
                        <textarea name="posudek_1"></textarea>
                        <input type="submit" name="posudek_1_submit">
                    <?php else: echo $sql_clanky_assoc['posudek_1'];
                          endif; ?>
                </td>
            </tr>
            <tr>
                <td>Posudek 2</td>
                <td>
                    <?php if ($sql_clanky_assoc['posudek_2'] == "") : ?>
                        <textarea name="posudek_2"></textarea>
                        <input type="submit" name="posudek_1_submit">
                    <?php else: echo $sql_clanky_assoc['posudek_2'];
                          endif; ?>
                </td>
            </tr>
        <?php endif;
        if ($_SESSION['adm'] == 1 || $_SESSION['red'] == 1) : ?>
            <tr>
                <td>Odemknout vložení opravy</td>
                <td><input type="submit" name="odemknout_opravu"></td>
            </tr>
        <?php endif; ?>
    </table>
</form>
