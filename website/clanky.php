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
// echo "<pre>"; print_r($sql_clanky_assoc); echo "</pre>";
 ?>

<table class="table">
    <tr>
        <td><b>Jméno autora</b></td>
        <td><b>E-mail autora</b></td>
        <td></td>
        <td><b>Přijat do recenzního řízení</b></td>
        <td></td>
    </tr>
    <?php
    foreach ($sql_clanky_assoc as $s) {
        $out = "<tr>";
        $out .=  "<td>".$s['autor_name']."</td>";
        $out .=  "<td>".$s['autor_mail']."</td>";
        $out .=  "<td>".$s['rok']."/".$s['ctvrtleti']."</td>";
        $out .=  "<td>".BitToText($s['schvaleno'])."</td>";
        $out .=  "<td><a href=\"?menu=clanky&c=".$s['index']."\">Otevřít</a>";
        $out .= "</tr>";

        echo $out;
    }
     ?>
</table>
