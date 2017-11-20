<title>LOGOS POLYTECHNIKOS</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<div class="container">
    <?php
    ini_set('display_startup_errors',1);
    ini_set('display_errors',1);
    error_reporting(-1);

    include_once("basic_functions.php");
    include_once("top_bar.php");

    $show_form = true;
    $link = mysqli_connect("127.0.0.1", "zelenk11", "Mor92Bud", "zelenk11");
    mysqli_set_charset($link, "utf8");

    if (isset($_POST['submit_upload']) || isset($_POST['submit_upload_oprava'])) {
        $file_dest = "uploads/";
        $time = 10000000000 + substr(str_replace(".", "", microtime(true)), 3);
        $file_name = $file_dest . $time . ".pdf";

        if ($_FILES["file_upload"]["size"] < 500000) {
            if (move_uploaded_file($_FILES["file_upload"]["tmp_name"], $file_name) == false) {
                echo "Nepodařilo se nahrát soubor.";
            } else {
                $index = $time; $autor_name = @$_POST['autor_jmeno']; $autor_mail = @$_POST['autor_mail']; @$cislo = $_POST['cis'];

                if (isset($_POST['submit_upload'])) {
                    $query = "INSERT INTO rsp_autori VALUES ('".$index."', '".$autor_name."', '".$autor_mail."', '-1', '".$cislo."', '-1', '', '', '-1')";
                } else {
                    $query = "UPDATE rsp_autori SET oprava='".$index."' WHERE rsp_autori.index='".$_GET['file']."'";
                }

                $sql = mysqli_query($link, $query);

                echo "Děkujeme za příspěvek.<br>";
                if (isset($_POST['submit_upload'])) {
                    echo "Na Váš e-mail byla odeslána automatická potvrzení o přijetí Vašeho článku.<br>
                      Stav Vašeho příspěvku můžete sledovat na adrese: <a href=\"?file=$index\">http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]?file=$index</a>";
                }
                // echo mysqli_error($link);

                $autor_text = "
                Děkujeme za odeslání článku do časopisu LOGOS POLYTECHNIKOS.<br>
                Stav vyřízení můžete sledovat na odkazu:<br>
                <a href=\"?file=$index\">http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]?file=$index</a><br>
                S pozdravem<br>
                Tým LOGOS POLYTECHNIKOS.
                ";
                $redaktor_text = "
                Do systému byl přidaný nový článek.<br>
                <table>
                    <tr>
                        <td>Jméno</td>
                        <td>".$autor_name."</td>
                    </tr>
                    <tr>
                        <td>E-mail</td>
                        <td>".$autor_mail."</td>
                    </tr>
                ";
                MailTo($autor_mail, "LOGOS POLYTECHNIKOS - přijetí článku", $autor_text);
                MailTo("gr33nnyg@gmail.com", "LOGOS POLYTECHNIKOS - přijetí článku", $redaktor_text);
            }
        }
        $show_form = false;
    }

    if (isset($_GET['file'])) :
        $query = "SELECT * FROM rsp_autori NATURAL JOIN rsp_casopisy WHERE rsp_autori.index = '".$_GET['file']."';";
        $sql = mysqli_query($link, $query);
        $autor_info_arr = mysqli_fetch_assoc($sql);
        $autor_num_rows = mysqli_num_rows($sql);
        echo mysqli_error($link);
        if ($autor_num_rows == 1) :
            ?>
            <table class="table">
                <tr>
                    <td>Jméno</td>
                    <td><?php echo $autor_info_arr['autor_name']; ?></td>
                </tr>
                <tr>
                    <td>Číso časopisu</td>
                    <td><?php echo $autor_info_arr['ctvrtleti']."/".$autor_info_arr['rok']; ?></td>
                </tr>
                <tr>
                    <td>Schváleno do recenzního řízení</td>
                    <td><?php echo BitToText($autor_info_arr['schvaleno']); ?></td>
                </tr>
                <tr>
                    <td>Posudek 1</td>
                    <td><?php if ($autor_info_arr['posudek_1'] != "") { echo $autor_info_arr['posudek_1']; } else { echo "Nerozhodnuto"; } ?></td>
                </tr>
                <tr>
                    <td>Posudek 2</td>
                    <td><?php if ($autor_info_arr['posudek_2'] != "") { echo $autor_info_arr['posudek_2']; } else { echo "Nerozhodnuto"; } ?></td>
                </tr>
                <tr>
                    <td>Příspěvek přijat</td>
                    <td><?php echo BitToText($autor_info_arr['prijato']); ?></td>
                </tr>
                <?php if ($autor_info_arr['oprava'] == 0): ?>
                    <tr>
                        <td>Vložit opravu</td>
                        <td>
                            <form method="post" action="" enctype="multipart/form-data">
                                <input type="file" name="file_upload" accept="application/pdf">
                                <input type="submit" name="submit_upload_oprava">
                            </form>
                        </td>
                    </tr>
                <?php endif; ?>
            </table>
    <?php
        endif;
        $show_form = false;
    endif;

    if ($show_form) : ?>
        <form method="post" action="" enctype="multipart/form-data">
            <table class="table">
                <tr>
                    <td colspan="2">Nahrání článku:</td>
                </tr>
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
                    <td><input type="submit" name="submit_upload" value="Poslat článek"></td>
                </tr>
            </table>
        </form>
    <?php
    endif;
     ?>
</div>
