<?php
$show_form = true;
$link = mysqli_connect("127.0.0.1", "zelenk11", "Mor92Bud", "zelenk11");
mysqli_set_charset($link, "utf8");

if (isset($_POST['submit_upload']) || isset($_POST['submit_upload_oprava'])) {
    $file_dest = "uploads/";
    $time = substr(str_replace(".", "", microtime(true)), 3);
    $file_name = $file_dest . $time . ".pdf";

    if ($_FILES["file_upload"]["size"] < 250000) {
        if (move_uploaded_file($_FILES["file_upload"]["tmp_name"], $file_name) == false) {
            echo "Nepodařilo se nahrát soubor.";
        } else {
            $index = $time; $autor_name = $_POST['autor_jmeno']; $autor_mail = $_POST['autor_mail']; $oprava = -1; $cislo = $_POST['cis'];

            if (isset($_POST['submit_upload'])) {
                $query = "INSERT INTO rsp_autori VALUES ('".$index."', '".$autor_name."', '".$autor_mail."', '".$oprava."', '".$cislo."')";
            } else {
                $query = "UPDATE rsp_autori SET oprava='".$index."' WHERE index='".$_GET['file']."'";
            }

            $sql = mysqli_query($link, $query);

            echo "Děkujeme za příspěvek.<br>
            Na Váš e-mail byla odeslána automatická potvrzení o přijetí Vašeho článku.<br>
            Stav Vašeho příspěvku můžete sledovat na adrese: <a href=\"?file=$index\">http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]?file=$index</a>";

            // echo mysqli_error($link);

            // poslat mail pro autora
            // poslat mail pro redakci ze byl vlozeny clanek
        }
    }

    $show_form = false;
}

if (isset($_GET['file'])) : ?>
    <table>
        <tr>
            <td>Jméno</td>
            <td></td>
        </tr>
        <tr>
            <td>Číso časopisu</td>
            <td></td>
        </tr>
        <tr>
            <td>Schváleno do recenzního řízení</td>
            <td></td>
        </tr>
        <tr>
            <td>Posudek 1</td>
            <td></td>
        </tr>
        <tr>
            <td>Posudek 2</td>
            <td></td>
        </tr>
        <tr>
            <td>Příspěvek přijat</td>
            <td></td>
        </tr>
        <tr>
            <td>Vložit opravu</td>
            <td>
                <form method="post" action="" enctype="multipart/form-data">
                    <input type="file" name="file_upload" accept="application/pdf">
                    <input type="submit" name="submit_upload_oprava">
                </form>
            </td>
        </tr>
    </table>
<?php
    $show_form = false;
endif;

if ($show_form) : ?>
    <form method="post" action="" enctype="multipart/form-data">
        <table>
            <tr>
                <td>Jméno:</td>
                <td><input type="text" name="autor_jmeno" ></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input type="email" name="autor_mail" ></td>
            </tr>
            <tr>
                <td>Časopis:</td>
                    <?php
                    $query_load_casopisy = "SELECT * FROM rsp_casopisy ORDER BY rok, ctvrtleti";
                    $sql_casopisy = mysqli_query($link, $query_load_casopisy);

                    while ($row = mysqli_fetch_array($sql_casopisy, MYSQLI_ASSOC)) {
                        $sql_casopisy_assoc[] = $row;
                    }
                     ?>
                <td><select name="cis">
                    <?php
                    foreach ($sql_casopisy_assoc as $s) {
                        echo "<option value=\"".$s['cislo']."\">".$s['rok']."/".$s['ctvrtleti']." - ".$s['tema']."</option>";
                    }
                     ?>
                </select></td>
            </tr>
            <tr>
                <td>Článek:</td>
                <td><input type="file" name="file_upload" accept="application/pdf"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="submit_upload"></td>
            </tr>
        </table>
    </form>
<?php
endif;
 ?>
