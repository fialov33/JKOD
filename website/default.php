Vítejte na stránkách časopisu LOGOS POLYTECHNIKOS.<br><br>
<?php
if ($_SESSION['adm'] == 1) {
}
elseif ($_SESSION['red'] == 1) {
    $query_neschvaleno = "SELECT * FROM rsp_autori NATURAL JOIN rsp_casopisy WHERE schvaleno = '-1';";
    $sql_neschvaleno = mysqli_query($link, $query_neschvaleno);
    if (mysqli_num_rows($sql_neschvaleno) > 0) {
        echo "Nevyřízené články:".
        "<table class=\"table table-striped\">".
        "<thead><tr><td><b>Jméno</b></td><td><b>Číslo časopisu</b></td><td><td></tr></thead>";
        while ($row = mysqli_fetch_assoc($sql_neschvaleno)) {
            echo
            "<tr>".
            "<td>".$row['autor_name']."</td>".
            "<td>".$row['ctvrtleti']."/".$row['rok']."</td>".
            "<td><a href=\"?menu=clanky&c=".$row['index']."\" target=\"_blank\">Oteřít</a></td>".
            "</tr>";
        }
        echo "</table>";
    }

} elseif ($_SESSION['rec'] == 1) {
    $query_bez_posudku = "SELECT * FROM rsp_autori NATURAL JOIN rsp_casopisy WHERE posudek_1 = '' AND posudek_1_priradit = '".$_SESSION['logos_polytechnikos_login']."' OR posudek_2 = '' AND posudek_2_priradit = '".$_SESSION['logos_polytechnikos_login']."';";
    $sql_bez_posudku = mysqli_query($link, $query_bez_posudku);
    if (mysqli_num_rows($sql_bez_posudku) > 0) {
        echo "Nevyřízené články:".
        "<table class=\"table table-striped\">".
        "<thead><tr><td><b>Jméno</b></td><td><b>Číslo časopisu</b></td><td><td></tr><thead>";
        while ($row = mysqli_fetch_assoc($sql_bez_posudku)) {
            echo
            "<tr>".
            "<td>".$row['autor_name']."</td>".
            "<td>".$row['ctvrtleti']."/".$row['rok']."</td>".
            "<td><a href=\"?menu=clanky&c=".$row['index']."\" target=\"_blank\">Oteřít</a></td>".
            "</tr>";
        }
        echo "</table>";
    }
}

?>
