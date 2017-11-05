<i>casopis<br>
nastaveni kapacity casopisu<br>
nastaveni temat<br></i>

<?php
if (isset($_POST['novy_casopis'])) {
    $rok = $_POST['rok'];
    $ctvrtleti = $_POST['ctvrt'];
    $tema = $_POST['tema'];
    $kapacita = $_POST['kap'];
    $query_set_casopis = "INSERT INTO rsp_casopisy (rok, ctvrtleti, tema, kapacita) VALUES ('".$rok."', '".$ctvrtleti."', '".$tema."', '".$kapacita."')";
    $sql = mysqli_query($link, $query_set_casopis);

    //echo mysqli_error($link);
}
if (isset($_GET['remove'])) {
    $query_remove_casopis = "DELETE FROM rsp_casopisy WHERE cislo='".$_GET['remove']."'";
    $sql = mysqli_query($link, $query_remove_casopis);
}
 ?>
<form method="post">
    <table>
        <tr>
            <td colspan="2">Přidat nové číslo:</td>
        </tr>
        <tr>
            <td>Rok:</td>
            <td><input type="number" name="rok" value="<?php echo date("Y"); ?>" min="2000" max="2100"></td>
        </tr>
        <tr>
            <td>Čtvrtletí:</td>
            <td><input type="number" name="ctvrt" value="1" min="1" max="4"></td>
        </tr>
        <tr>
            <td>Kapacita:</td>
            <td><input type="number" name="kap" value="1" min="1" max="100"></td>
        </tr>
        <tr>
            <td>Téma:</td>
            <td><input type="text" name="tema"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="novy_casopis"></td>
        </tr>
    </table>
</form>

<?php
$query_load_casopisy = "SELECT * FROM rsp_casopisy ORDER BY rok, ctvrtleti";
$sql_casopisy = mysqli_query($link, $query_load_casopisy);

while ($row = mysqli_fetch_array($sql_casopisy, MYSQLI_ASSOC)) {
    $sql_casopisy_assoc[] = $row;
}
echo "<pre>"; print_r($sql_casopisy_assoc); echo "</pre>";
 ?>

<table>
    <tr>
        <td></td>
        <td>Téma</td>
        <td>Kapacita</td>
        <td></td>
        <td></td>
    </tr>
    <?php
    foreach ($sql_casopisy_assoc as $s) {
        echo
        "<tr>".
            "<td>".$s['rok']."/".$s['ctvrtleti']."</td>".
            "<td>".$s['tema']."</td>".
            "<td>".$s['kapacita']."</td>".
            "<td><a href=\"?menu=clanky&cislo=".$s['cislo']."\">zobrazit články</a><td>".
            "<td><a href=\"?menu=casopis&remove=".$s['cislo']."\">odebrat</a></td>".
        "</tr>"
        ;
    }
     ?>
</table>
