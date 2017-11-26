<?php
if (isset($_GET['cislo'])) {
    $query_load_clanky = "SELECT * FROM rsp_autori NATURAL JOIN rsp_casopisy WHERE rsp_autori.cislo='".$_GET['cislo']."' AND schvaleno = 1";
} else {
    $query_load_clanky = "SELECT * FROM rsp_autori NATURAL JOIN rsp_casopisy";
}

if (isset($_GET['order'])) {
    $query_load_clanky .= " ORDER BY ".$_GET['order'];
}

if (isset($_GET['o'])) {
    $query_load_clanky .= " DESC";
}

$sql_clanky = mysqli_query($link, $query_load_clanky);

while ($row = mysqli_fetch_array($sql_clanky, MYSQLI_ASSOC)) {
    $sql_clanky_assoc[] = $row;
}
// echo "<pre>"; print_r($sql_clanky_assoc); echo "</pre>";
 ?>

<table class="table">
    <tr>
        <?php
        $href = "?menu=clanky";
        if (isset($_GET['cislo'])) {
            $href .= "&cislo=".$_GET['cislo'];
        }
        $href .= "&order=";
        ?>
        <td><b><a href="<?php echo $href.'autor_name'; if (isset($_GET['order'])) { if ($_GET['order'] == 'autor_name' && !isset($_GET['o'])) { echo '&o=desc'; } }; ?>">Jméno autora</a></b></td>
        <td><b><a href="<?php echo $href.'autor_mail'; if (isset($_GET['order'])) { if ($_GET['order'] == 'autor_mail' && !isset($_GET['o'])) { echo '&o=desc'; } }; ?>">E-mail autora</a></b></td>
        <td><b><a href="<?php echo $href.'cislo'; if (isset($_GET['order'])) { if ($_GET['order'] == 'cislo' && !isset($_GET['o'])) { echo '&o=desc'; } }; ?>">Číslo</a></b></td>
        <td><b><a href="<?php echo $href.'schvaleno'; if (isset($_GET['order'])) { if ($_GET['order'] == 'schvaleno' && !isset($_GET['o'])) { echo '&o=desc'; } }; ?>">Přijat do recenzního řízení</a></b></td>
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
