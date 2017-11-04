casopis<br>
nastaveni kapacity casopisu<br>
nastaveni temat<br>

<?php
$show_form = true;
if (isset($_POST['novy_casopis'])) {
    $rok = $_POST['rok'];
    $ctvrtleti = $_POST['ctvrt'];
    $tema = $_POST['tema'];
    $query_set_casopis = "INSERT INTO rsp_casopisy (rok, ctvrtleti, tema) VALUES ('".$rok."', '".$ctvrtleti."', '".$tema."')";
    $sql = mysqli_query($link, $query_set_casopis);

    //echo mysqli_error($link);

    $show_form = false;
}

if ($show_form) : ?>
    <form method="post">
        Přidat nové číslo:<br>
        Rok:<input type="number" name="rok" value="<?php echo date("Y"); ?>" min="2000" max="2100"><br>
        Čtvrtletí:<input type="number" name="ctvrt" value="1" min="1" max="4"><br>
        Téma:<input type="text" name="tema"><br>
        <input type="submit" name="novy_casopis"><br>
    </form>
<?php
endif;

$query_load_casopisy = "SELECT * FROM rsp_casopisy";
$sql_casopisy = mysqli_query($link, $query_load_casopisy);

while ($row = mysqli_fetch_array($sql_casopisy, MYSQLI_ASSOC)) {
    $sql_casopisy_assoc[] = $row;
}
 ?>

<table>
    <tr>
        <td></td>
        <td>Téma</td>
    </tr>
    <?php
    foreach ($sql_casopisy_assoc as $s) {
        echo
        "<tr>".
            "<td>".$s['rok']."/".$s['ctvrtleti']."</td>".
            "<td>".$s['tema']."</td>".
        "</tr>"
        ;
    }
     ?>
</table>
