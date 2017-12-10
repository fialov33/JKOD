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
if ($_SESSION['adm'] == 1 || $_SESSION['red'] == 1) : ?>
<form method="post">
    <table class="table table-striped">
        <thead>
            <tr>
                <td colspan="2"><b>Přidat nové číslo:</b></td>
            </tr>
        </thead>
        <tr>
            <td>Rok:</td>
            <td><input type="number" name="rok" value="<?php echo date("Y"); ?>" min="2000" max="2100" class="form-control"></td>
        </tr>
        <tr>
            <td>Čtvrtletí:</td>
            <td><input type="number" name="ctvrt" value="1" min="1" max="4" class="form-control"></td>
        </tr>
        <tr>
            <td>Kapacita:</td>
            <td><input type="number" name="kap" value="1" min="1" max="100" class="form-control"></td>
        </tr>
        <tr>
            <td>Téma:</td>
            <td><input type="text" name="tema" class="form-control"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="novy_casopis" class="btn-default btn"></td>
        </tr>
    </table>
</form>
<?php
endif;

$query_load_casopisy = "SELECT * FROM rsp_casopisy ORDER BY rok, ctvrtleti";
$sql_casopisy = mysqli_query($link, $query_load_casopisy);

while ($row = mysqli_fetch_array($sql_casopisy, MYSQLI_ASSOC)) {
    $sql_casopisy_assoc[] = $row;
}
// echo "<pre>"; print_r($sql_casopisy_assoc); echo "</pre>";
?>

<table class="table table-striped">
    <thead>
        <tr>
            <td></td>
            <td><b>Téma</b></td>
            <td><b>Kapacita</b></td>
            <td><b>Přijato do recenzního řízení</b></td>
            <td></td>
            <?php if ($_SESSION['adm'] == 1): ?>
                <td></td>
            <?php endif; ?>
        </tr>
    </thead>
    <?php
    foreach ($sql_casopisy_assoc as $s) {
        $query_num_clanky = "SELECT * FROM rsp_autori WHERE cislo='".$s['cislo']."' AND schvaleno = 1;";
        $sql_num_clanky = mysqli_query($link, $query_num_clanky);
        $clanky_prijato = mysqli_num_rows($sql_num_clanky);
        
        $query_kapacita = "SELECT * FROM rsp_autori WHERE cislo='".$s['cislo']."' AND prijato = 1;";
        $sql_kapacita = mysqli_query($link, $query_kapacita);
        $kapacita = mysqli_num_rows($sql_kapacita);
        echo
        "<tr>".
        "<td>".$s['rok']."/".$s['ctvrtleti']."</td>".
        "<td>".$s['tema']."</td>".
        "<td>".$kapacita."/".$s['kapacita']."</td>".
        "<td>".$clanky_prijato."</td>";
        if ($clanky_prijato >= 1) {
            echo "<td><a href=\"?menu=clanky&cislo=".$s['cislo']."\">zobrazit články</a><td>";
        }
        if ($_SESSION['adm'] == 1 && $clanky_prijato == 0) {
            echo "<td><a href=\"?menu=casopis&remove=".$s['cislo']."\">odebrat</a></td>";
        }
        echo "</tr>";
    }
    ?>
</table>
