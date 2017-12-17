<?php
if (isset($_GET['filter_submit'])) {
    $query_load_clanky = "SELECT * FROM rsp_autori NATURAL JOIN rsp_casopisy WHERE rsp_autori.cislo='".$_GET['cislo']."'";
    if ($_GET['autor_name'] != "") {
        $query_load_clanky .= " AND rsp_autori.autor_name LIKE '%".$_GET['autor_name']."%'";
    }
    if ($_GET['autor_mail'] != "") {
        $query_load_clanky .= " AND rsp_autori.autor_mail LIKE '%".$_GET['autor_mail']."%'";
    }
    $query_load_clanky .= " AND schvaleno = '".$_GET['schvaleno']."'";

} elseif (isset($_GET['cislo'])) {
    $query_load_clanky = "SELECT * FROM rsp_autori NATURAL JOIN rsp_casopisy WHERE rsp_autori.cislo='".$_GET['cislo']."' AND schvaleno = 1";
} else {
    $query_load_clanky = "SELECT * FROM rsp_autori NATURAL JOIN rsp_casopisy";
    if (isset($_GET['autor_mail'])) {
        $query_load_clanky .= " WHERE autor_mail = '".$_GET['autor_mail']."'";
    }
}

if (isset($_GET['order'])) {
    $query_load_clanky .= " ORDER BY ".$_GET['order'];
}

if (isset($_GET['o'])) {
    $query_load_clanky .= " DESC";
}

//echo $query_load_clanky;

$sql_clanky = mysqli_query($link, $query_load_clanky);

while ($row = mysqli_fetch_array($sql_clanky, MYSQLI_ASSOC)) {
    $sql_clanky_assoc[] = $row;
}
// echo "<pre>"; print_r($sql_clanky_assoc); echo "</pre>";
?>

<style>
.filter
{
    display: inline-block;
    width: 10em;
    vertical-align: middle;
}
.filter-check
{
    display: inline-block;
    width: 3em;
    vertical-align: middle;
}
</style>

<form method="get">
        <input type="hidden" name="menu" value="clanky">

        <?php
        if (isset($_GET['cislo'])) :
        ?>
            <input type="hidden" name="cislo" value="<?php echo $_GET['cislo']; ?>">
        <?php
        endif;
        if (isset($_GET['o'])) :
         ?>
            <input type="hidden" name="o" value="<?php echo $_GET['o']; ?>">
        <?php
        endif;
         ?>

    Jméno autora: <input type="text" name="autor_name" class="form-control filter" value="<?php if (isset($_GET['autor_name'])) echo $_GET['autor_name']; ?>">&nbsp;&nbsp;
    E-mail autora: <input type="email" name="autor_mail" class="form-control filter" value="<?php if (isset($_GET['autor_mail'])) echo $_GET['autor_mail']; ?>">&nbsp;&nbsp;
    Číslo:
    <select name="cislo" class="form-control filter">
        <?php
        $query_load_casopisy = "SELECT * FROM rsp_casopisy ORDER BY rok, ctvrtleti";
        $sql_casopisy = mysqli_query($link, $query_load_casopisy);

        while ($row = mysqli_fetch_array($sql_casopisy, MYSQLI_ASSOC)) {
            echo "<option value=\"".$row['cislo']."\"";
            if (isset($_GET['cislo']) && $_GET['cislo'] == $row['cislo']) {
                echo "selected";
            }
            echo ">".$row['rok']."/".$row['ctvrtleti']."</option>";
        }
         ?>
    </select>&nbsp;&nbsp;
    Přijato k recenzi:
    <select name="schvaleno" class="form-control filter">
        <option value="1" <?php if (isset($_GET['schvaleno']) && $_GET['schvaleno'] == '1') echo "selected"; ?>>Ano</option>
        <option value="0" <?php if (isset($_GET['schvaleno']) && $_GET['schvaleno'] == '0') echo "selected"; ?>>Ne</option>
        <option value="-1" <?php if (isset($_GET['schvaleno']) && $_GET['schvaleno'] == '-1') echo "selected"; ?>>Nerozhodnuto</option>
    </select>
    &nbsp;&nbsp;
    <input type="submit" name="filter_submit" value="Vyhledat" class="btn-default btn filter">
</form>

<?php
if (count(@$sql_clanky_assoc) == 0) :
?>
<b>Nebyly nalezeny žádné články vyhovující hledaným parametrům.</b>
<?php
else :
 ?>
    <table class="table table-striped">
        <tr>
            <thead>
                <?php
                $href = "?menu=clanky";
                if (isset($_GET['cislo'])) {
                    $href .= "&cislo=".$_GET['cislo'];
                }
                if (isset($_GET['autor_mail'])) {
                    $href .= "&autor_mail=".$_GET['autor_mail'];
                }
                $href .= "&order=";
                ?>
                <td>
                    <b><a href="<?php echo $href.'autor_name'; if (isset($_GET['order'])) { if ($_GET['order'] == 'autor_name' && !isset($_GET['o'])) { echo '&o=desc'; } }; ?>">Jméno autora</a></b>
                </td>
                <td>
                    <b><a href="<?php echo $href.'autor_mail'; if (isset($_GET['order'])) { if ($_GET['order'] == 'autor_mail' && !isset($_GET['o'])) { echo '&o=desc'; } }; ?>">E-mail autora</a></b>
                </td>
                <td>
                   <b><a href="<?php echo $href.'cislo'; if (isset($_GET['order'])) { if ($_GET['order'] == 'cislo' && !isset($_GET['o'])) { echo '&o=desc'; } }; ?>">Číslo</a></b>
                </td>
                <td>
                    <b><a href="<?php echo $href.'schvaleno'; if (isset($_GET['order'])) { if ($_GET['order'] == 'schvaleno' && !isset($_GET['o'])) { echo '&o=desc'; } }; ?>">Přijat do recenzního řízení</a></b>
                </td>
                <td></td>
            </tr>
        </thead>
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
<?php
endif;
 ?>
