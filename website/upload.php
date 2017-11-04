<?php
$show_form = true;
if (isset($_POST['submit_upload'])) {
    $file_dest = "uploads/";
    $time = substr(str_replace(".", "", microtime(true)), 3);
    $file_name = $file_dest . $time . ".pdf";

    if ($_FILES["file_upload"]["size"] < 250000) {
        if (move_uploaded_file($_FILES["file_upload"]["tmp_name"], $file_name) == false) {
            echo "Nepodařilo se nahrát soubor.";
        } else {
            $index = $time; $autor_name = $_POST['autor_jmeno']; $autor_mail = $_POST['autor_mail']; $oprava = -1;

            $link = mysqli_connect("127.0.0.1", "zelenk11", "Mor92Bud", "zelenk11");

            $query = "INSERT INTO rsp_autori VALUES ('".$index."', '".$autor_name."', '".$autor_mail."', '".$oprava."')";
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

if (isset($_GET['file'])) {
    echo "string";
    // info o vkladani
    // schvaleno x neschvaleno
    // recenze 1 stav
    // recenze 2 stav
    // vlozit opravu

    $show_form = false;
}

if ($show_form) : ?>
    <form method="post" action="" enctype="multipart/form-data">
        Jméno:<input type="text" name="autor_jmeno" ><br>
        Email:<input type="email" name="autor_mail" ><br>
        Časopis:
            <select>
                <option value=""></option>
            </select>
        <br>
        Článek:<input type="file" name="file_upload" accept="application/pdf"><br>
        <input type="submit" name="submit_upload">
    </form>
<?php
endif;
 ?>
