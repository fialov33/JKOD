<?php
if (isset($_POST['prijmout_k_recenzi'])) {
    $query_schvalit = "UPDATE rsp_autori SET schvaleno='1' WHERE rsp_autori.index='".$_GET['c']."'";
    $sql = mysqli_query($link, $query_schvalit);
}
if (isset($_POST['zamitnout_k_recenzi'])) {
    $query_zamitnout = "UPDATE rsp_autori SET schvaleno='0' WHERE rsp_autori.index='".$_GET['c']."'";
    $sql = mysqli_query($link, $query_zamitnout);
}
if (isset($_POST['posudek_1_submit'])) {
    $query_posudek_1 = "UPDATE rsp_autori SET posudek_1='".$_POST['posudek_1']."' WHERE rsp_autori.index='".$_GET['c']."'";
    $sql = mysqli_query($link, $query_posudek_1);
}
if (isset($_POST['posudek_2_submit'])) {
    $query_posudek_2 = "UPDATE rsp_autori SET posudek_2='".$_POST['posudek_2']."' WHERE rsp_autori.index='".$_GET['c']."'";
    $sql = mysqli_query($link, $query_posudek_2);
}
if (isset($_POST['odemknout_opravu'])) {
    $query_oprava = "UPDATE rsp_autori SET oprava='0' WHERE rsp_autori.index='".$_GET['c']."'";
    $sql = mysqli_query($link, $query_oprava);
}
if (isset($_POST['odeslat_mail'])) {
    $query_load_clanky = "SELECT * FROM rsp_autori NATURAL JOIN rsp_casopisy WHERE rsp_autori.index = '".$_GET['c']."';";
    $sql_clanky = mysqli_query($link, $query_load_clanky);
    $sql_clanky_assoc = mysqli_fetch_array($sql_clanky, MYSQLI_ASSOC);

    MailTo($sql_clanky_assoc['autor_mail'], "Článek č. ".$sql_clanky_assoc['index'], $_POST['mail_area']);

    echo "<b>E-mail byl úspěšně odeslaný.</b><br>";
}
if (isset($_POST['priradit_pos_1'])) {
    $query_posudek = "UPDATE rsp_autori SET posudek_1_priradit = '".$_POST['select_pos_1']."' WHERE rsp_autori.index = '".$_GET['c']."';";
    $sql_posudek = mysqli_query($link, $query_posudek);
}
if (isset($_POST['priradit_pos_2'])) {
    $query_posudek = "UPDATE rsp_autori SET posudek_2_priradit = '".$_POST['select_pos_2']."' WHERE rsp_autori.index = '".$_GET['c']."';";
    $sql_posudek = mysqli_query($link, $query_posudek);
}
if (isset($_POST['prijmoout_do_casopisu'])) {
    $query_prijmout = "UPDATE rsp_autori SET prijato = '1' WHERE rsp_autori.index = '".$_GET['c']."';";
    $sql_prijmout = mysqli_query($link, $query_prijmout);
}
if (isset($_POST['odmitnout_do_casopisu'])) {
    $query_odmitnout = "UPDATE rsp_autori SET prijato = '0' WHERE rsp_autori.index = '".$_GET['c']."';";
    $sql_odmitnout = mysqli_query($link, $query_odmitnout);
}

$query_load_clanky = "SELECT * FROM rsp_autori NATURAL JOIN rsp_casopisy WHERE rsp_autori.index = '".$_GET['c']."';";
$sql_clanky = mysqli_query($link, $query_load_clanky);

$sql_clanky_assoc = mysqli_fetch_array($sql_clanky, MYSQLI_ASSOC);
// echo "<pre>"; print_r($sql_clanky_assoc); echo "</pre>";

$query_num_clanky = "SELECT * FROM rsp_casopisy NATURAL JOIN rsp_autori WHERE cislo = '".$sql_clanky_assoc['cislo']."' AND prijato = '1';";
$sql_num_clanky = mysqli_query($link, $query_num_clanky);
$clanky_num = mysqli_num_rows($sql_num_clanky);
?>

<table class="table table-striped">
    <tr>
        <td>Jméno autora</td>
        <td><?php echo $sql_clanky_assoc['autor_name']; ?></td>
    </tr>
    <tr>
        <td>E-mail</td>
        <td><?php echo $sql_clanky_assoc['autor_mail']; ?></td>
    </tr>
    <tr>
        <td>Číslo časopisu</td>
        <td><?php echo $sql_clanky_assoc['rok']."/".$sql_clanky_assoc['ctvrtleti']; ?></td>
    </tr>
    <tr>
        <td>Téma časopisu</td>
        <td><?php echo $sql_clanky_assoc['tema']; ?></td>
    </tr>
    <tr>
        <td>Kapacita</td>
        <td><?php echo $clanky_num."/".$sql_clanky_assoc['kapacita']; ?></td>
    </tr>
    <tr>
        <td>E-mail</td>
        <td>
            <form method="post">
                <textarea name="mail_area" rows="5" cols="75" class="form-control">Toto je ukázkový text e-mailu</textarea><br>
                <input type="submit" name="odeslat_mail" value="Odeslat e-mail" class="btn-default btn">
            </form>
        </td>
    </tr>
</table>

<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Článek</a>
            </h4>
        </div>
        <div id="collapse1" class="panel-collapse collapse">
            <div class="panel-body">
                <embed src="http://195.113.207.171/~zelenk11/rsp/uploads/<?php echo $sql_clanky_assoc['index']; ?>.pdf" width="990" height="700" type='application/pdf'></embed>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Oprava</a>
            </h4>
        </div>
        <div id="collapse2" class="panel-collapse collapse">
            <div class="panel-body">
                <?php
                if ($sql_clanky_assoc['oprava'] > 0) : ?>
                <embed src="http://195.113.207.171/~zelenk11/rsp/uploads/<?php echo $sql_clanky_assoc['oprava']; ?>.pdf" width="990" height="700" type='application/pdf'></embed>
                <?php
                else:
                 ?>
                Oprava nebyla odemknutá nebo ještě nebyla vložená.
                <?php
                endif;
                ?>
            </div>
        </div>
    </div>
</div>

<form method="post">
    <table class="table table-striped">
        <?php if ($_SESSION['adm'] == 1 || $_SESSION['red'] == 1) : ?>
            <tr>
                <td>Přijmout do recenzního řízení</td>
                <td>
                    <?php if ($sql_clanky_assoc['schvaleno'] == -1) : ?>
                        <input type="submit" name="prijmout_k_recenzi" value="Přijmout" class="btn-default btn">
                        <input type="submit" name="zamitnout_k_recenzi" value="Zamítnout" class="btn-default btn">
                    <?php else: echo BitToText($sql_clanky_assoc['schvaleno']);
                endif; ?>
            </td>
        </tr>
        <?php if ($sql_clanky_assoc['schvaleno'] == 1): ?>
            <tr>
                <td>Přiřadit posudek 1</td>
                <td>
                    <?php if ($sql_clanky_assoc['posudek_1_priradit'] == ""): ?>
                        <select name="select_pos_1" class="form-control">
                            <?php
                            $query_recenzenti = "SELECT * FROM rsp_users WHERE recenzent = 1";
                            $sql_recenzenti = mysqli_query($link, $query_recenzenti);
                            while ($row = mysqli_fetch_assoc($sql_recenzenti)) {
                                echo "<option value=\"".$row['username']."\">".$row['username']."</option>";
                            }
                            ?>
                        </select>
                        <br>
                        <input type="submit" name="priradit_pos_1" class="btn-default btn">
                    <?php else: echo $sql_clanky_assoc['posudek_1_priradit']; ?>
                    <?php endif; ?>

                </td>
            </tr>
        <?php endif; ?>
    <?php endif; ?>
    <?php if (($sql_clanky_assoc['posudek_1_priradit'] == $_SESSION['logos_polytechnikos_login'] || $_SESSION['adm'] == 1 || $_SESSION['red'] == 1) && $sql_clanky_assoc['schvaleno'] == 1  && $sql_clanky_assoc['posudek_1_priradit'] != ""): ?>
        <tr>
            <td>Posudek 1</td>
            <td>
                <?php if ($sql_clanky_assoc['posudek_1'] == "") : ?>
                    <textarea name="posudek_1" cols="75" class="form-control"></textarea><br>
                    <input type="submit" name="posudek_1_submit" class="btn-default btn">
                <?php else: echo $sql_clanky_assoc['posudek_1'];
                endif; ?>
            </td>
        </tr>
    <?php endif; ?>
    <?php if (($_SESSION['adm'] == 1 || $_SESSION['red'] == 1) && $sql_clanky_assoc['schvaleno'] == 1): ?>
        <tr>
            <td>Přiřadit posudek 2</td>
            <td>
                <?php if ($sql_clanky_assoc['posudek_2_priradit'] == ""): ?>
                    <select name="select_pos_2" class="form-control">
                        <?php
                        $query_recenzenti = "SELECT * FROM rsp_users WHERE recenzent = 1";
                        $sql_recenzenti = mysqli_query($link, $query_recenzenti);
                        while ($row = mysqli_fetch_assoc($sql_recenzenti)) {
                            echo "<option value=\"".$row['username']."\">".$row['username']."</option>";
                        }
                        ?>
                    </select>
                    <br>
                    <input type="submit" name="priradit_pos_2" class="btn-default btn">
                <?php else: echo $sql_clanky_assoc['posudek_2_priradit']; ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endif; ?>
    <?php if (($sql_clanky_assoc['posudek_2_priradit'] == $_SESSION['logos_polytechnikos_login'] || $_SESSION['adm'] == 1 || $_SESSION['red'] == 1) && $sql_clanky_assoc['schvaleno'] == 1 && $sql_clanky_assoc['posudek_2_priradit'] != ""): ?>
        <tr>
            <td>Posudek 2</td>
            <td>
                <?php if ($sql_clanky_assoc['posudek_2'] == "") : ?>
                    <textarea name="posudek_2" cols="75" class="form-control"></textarea><br>
                    <input type="submit" name="posudek_2_submit" class="btn-default btn">
                <?php else: echo $sql_clanky_assoc['posudek_2'];
            endif; ?>
        </td>
    </tr>
    <?php endif; ?>
    <?php if (($_SESSION['adm'] == 1 || $_SESSION['red'] == 1) && $sql_clanky_assoc['oprava'] == -1) : ?>
        <tr>
            <td>Odemknout vložení opravy</td>
            <td><input type="submit" name="odemknout_opravu" class="btn-default btn"></td>
        </tr>
    <?php endif; ?>
    <?php if (($_SESSION['adm'] == 1 || $_SESSION['red'] == 1) && $sql_clanky_assoc['schvaleno'] == 1) ?>
    <tr>
        <td>Přijmout článek:</td>
        <td>
            <?php if ($sql_clanky_assoc['prijato'] == -1) : ?>
                <input type="submit" name="prijmoout_do_casopisu" value="Přijmout" class="btn-default btn">
                <input type="submit" name="odmitnout_do_casopisu" value="Odmítnout" class="btn-default btn">
            <?php else: echo BitToText($sql_clanky_assoc['prijato']); endif; ?>

            </td>
        </tr>
    </table>
</form>
