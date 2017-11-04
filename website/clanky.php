clanky<br>
potvrzeni zda jsou clanky prijate do recenzniho rizeni<br>
odeslání mailu s preddefinovanym textem/vlastni nastaveni obsahu<br>
vkladani informaci u prijatych clanku<br>
nahrani posudku recenze<br>

<?php
$query_load_clanky = "SELECT * FROM rsp_autori";
$sql_clanky = mysqli_query($link, $query_load_clanky);

while ($row = mysqli_fetch_array($sql_clanky, MYSQLI_ASSOC)) {
    $sql_clanky_assoc[] = $row;
}
 ?>

<table>
    <tr>
        <td>Jméno autora</td>
        <td>E-mail autora</td>
        <td></td>
    </tr>
    <?php
    foreach ($sql_clanky_assoc as $s) {
        echo
        "<tr>".
            "<td>".$s['autor_name']."</td>".
            "<td>".$s['autor_mail']."</td>".
        "<td><a href=\"?menu=clanky&c=".$s['index']."\">Otevřít</a>"
        ;
    }
     ?>
</table>
