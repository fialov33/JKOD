Vítejte na stránkách časopisu LOGOS POLYTECHNIKOS.<br><br>
<?php
$query_nevyrizene = "SELECT * FROM rsp_autori NATURAL JOIN rsp_casopisy WHERE schvaleno='-1';";
$sql_nevyrizene = mysqli_query($link, $query_nevyrizene);
if (mysqli_num_rows($sql_nevyrizene) > 0) {
    echo "Nevyřízené články:".
    "<table class=\"table\">".
    "<tr><td><b>Jméno</b></td><td><b>Číslo</b></td><td><td></tr>";
    while ($row = mysqli_fetch_assoc($sql_nevyrizene)) {
        echo
        "<tr>".
            "<td>".$row['autor_name']."</td>".
            "<td>".$row['ctvrtleti']."/".$row['rok']."</td>".
            "<td><a href=\"?menu=clanky&c=".$row['index']."\" target=\"_blank\">Oteřít</a></td>".
        "</tr>";
    }
    echo "</table>";
}

?>
