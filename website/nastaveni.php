<?php
$file = "config.json";
$json = json_decode(file_get_contents($file),TRUE);

if (isset($_POST['mail_redakce_submit'])) {
    $json["config"] = array("redakce_mail" => $_POST['mail_redakce']);
    file_put_contents($file, json_encode($json));
}
 ?>

<form method="post">
    <table>
        <tr>
            <td>Nastavení e-mailu redakce:</td>
            <td><input type="email" name="mail_redakce" value="<?php echo $json['config']['redakce_mail']; ?>" class="form-control"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="mail_redakce_submit" value="Uložit" class="btn-default btn"></td>
        </tr>
    </table>
</form>
