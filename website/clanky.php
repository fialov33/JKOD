<i>clanky<br>
potvrzeni zda jsou clanky prijate do recenzniho rizeni<br>
odeslání mailu s preddefinovanym textem/vlastni nastaveni obsahu<br>
vkladani informaci u prijatych clanku<br>
nahrani posudku recenze<br></i>

<?php
if (isset($_GET['cislo'])) {
    $query_load_clanky = "SELECT * FROM rsp_autori NATURAL JOIN rsp_casopisy WHERE rsp_autori.cislo='".$_GET['cislo']."'";
} else {
    $query_load_clanky = "SELECT * FROM rsp_autori NATURAL JOIN rsp_casopisy";
}

$sql_clanky = mysqli_query($link, $query_load_clanky);

while ($row = mysqli_fetch_array($sql_clanky, MYSQLI_ASSOC)) {
    $sql_clanky_assoc[] = $row;
}
echo "<pre>"; print_r($sql_clanky_assoc); echo "</pre>";
 ?>

<table>
    <tr>
        <td>Jméno autora</td>
        <td>E-mail autora</td>
        <td></td>
        <td></td>
    </tr>
    <?php
    foreach ($sql_clanky_assoc as $s) {
        echo
        "<tr>".
            "<td>".$s['autor_name']."</td>".
            "<td>".$s['autor_mail']."</td>".
            "<td>".$s['rok']."/".$s['ctvrtleti']."</td>".
        "<td><a href=\"?menu=clanky&c=".$s['index']."\">Otevřít</a>"
        ;
    }
     ?>
</table>
