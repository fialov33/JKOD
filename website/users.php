<style>
    .checkbox
    {
        width:50px;
    }
</style>
<?php
if (isset($_POST['uzivatel_add'])) {
    $query_user_exist = "SELECT * FROM rsp_users WHERE username = '".$_POST['username']."'";
    $sql_user_exist = mysqli_query($link, $query_user_exist);
    if (mysqli_num_rows($sql_user_exist) != 0) {
        echo "Uživatel s tímto uživatelským jménem již existuje.";
    } else {
        $query_user_add = "INSERT INTO rsp_users VALUES ('".$_POST['username']."', '".$_POST['password']."', '".CheckboxToBit(@$_POST['adm'])."', '".CheckboxToBit(@$_POST['red'])."', '".CheckboxToBit(@$_POST['rec'])."');";
        $sql_user_add = mysqli_query($link, $query_user_add);
        echo "Uživatel byl úspěšně přidaný.<br>";
    }
}
if (isset($_POST['uzivatel_change'])) {
    $query_user_change = "UPDATE rsp_users SET username = '".$_POST['username']."', password = '".$_POST['password']."', administrator = '".CheckboxToBit(@$_POST['adm'])."', redaktor = '".CheckboxToBit(@$_POST['red'])."', recenzent = '".CheckboxToBit(@$_POST['rec'])."' WHERE username = '".$_POST['username']."';";
    $sql_user_change = mysqli_query($link, $query_user_change);
    echo "Změny byly úspěšně uložené.<br>";
}
if (isset($_POST['uzivatel_delete'])) {
    $query_user_delete = "DELETE FROM rsp_users WHERE username = '".$_POST['username']."'";
    $sql_user_delete = mysqli_query($link, $query_user_delete);
    echo "Uživatel ".$_POST['username']." byl úspěšně smazaný.<br>";
}

if ($_GET['u'] == "add") :
    if ($_SESSION['adm'] == 1) : ?>
    <table class="table table-striped">
        <form method="post">
            <thead>
                <tr>
                    <td colspan="2"><b>Přidání uživatele<b></td>
                </tr>
            </thead>
                <tbody>
                <tr>
                    <td>Uživatelské jméno</td>
                    <td><input type="text" name="username" class="form-control input-short" required></td>
                </tr>
                <tr>
                    <td>Heslo</td>
                    <td><input type="text" name="password" class="form-control input-short" required></td>
                </tr>
               <tr>
                   <td>Administrátor</td>
                    <td><input type="checkbox" name="adm" class="form-control checkbox"></td>
                </tr>
                <tr>
                    <td>Redaktor</td>
                    <td><input type="checkbox" name="red" class="form-control checkbox"></td>
                </tr>
                <tr>
                    <td>Recenzent</td>
                    <td><input type="checkbox" name="rec" class="form-control checkbox"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="uzivatel_add" class="btn-default btn"></td>
                </tr>
            </tbody>
        </form>
    </table>
<?php else:
    echo "Nemáte oprávnění přidávat uživatele. Pokud si přejete přidat nového uživatele nebo měnit stávající kontaktujte prosím administrátora.";
    endif;
endif;

if ($_GET['u'] == "view") {
    if (isset($_GET['user']) && $_SESSION['adm'] == 1) {
        $query_users = "SELECT * FROM rsp_users WHERE username = '".$_GET['user']."';";
        $sql_users = mysqli_query($link, $query_users);
        $user_assoc = mysqli_fetch_assoc($sql_users);
        ?>
        <table class="table table-striped">
            <form method="post" action="?menu=users&amp;u=view">
                <thead>
                    <tr>
                        <td colspan="2"><b>Úprava uživatele</b></td>
                    </tr>
                </thead>
                <tr>
                    <td>Uživatelské jméno</td>
                    <td><input type="text" name="username" value="<?php echo $user_assoc['username']; ?>" class="form-control input-short" required></td>
                </tr>
                <tr>
                    <td>Heslo</td>
                    <td><input type="text" name="password" value="<?php echo $user_assoc['password']; ?>" class="form-control input-short" required></td>
                </tr>
                <tr>
                    <td>Administrátor</td>
                    <td><input type="checkbox" name="adm" <?php if ($user_assoc['administrator'] == 1) echo "checked" ?> class="form-control checkbox"></td>
                </tr>
                <tr>
                    <td>Redaktor</td>
                    <td><input type="checkbox" name="red" <?php if ($user_assoc['redaktor'] == 1) echo "checked" ?> class="form-control checkbox"></td>
                </tr>
                <tr>
                    <td>Recenzent</td>
                    <td><input type="checkbox" name="rec" <?php if ($user_assoc['recenzent'] == 1) echo "checked" ?> class="form-control checkbox"></td>
                </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="uzivatel_change" class="btn-default btn" value="Uložit">
                            <input type="submit" name="uzivatel_delete" class="btn-default btn btn-danger" style="float: right;" value="Smazat uživatele">
                        </td>
                    </tr>
            </form>
        </table>
        <?php
    } else {
        $query_users = "SELECT * FROM rsp_users";
        $sql_users = mysqli_query($link, $query_users);
        echo
        "<table class=\"table\">".
            "<tr><td><b>Jméno</b></td><td><b>Administrátor</b></td><td><b>Redaktor</b></td><td><b>Recenzent</b></td><td><td><tr>"
        ;
        while ($row = mysqli_fetch_assoc($sql_users)) {
            echo
            "<tr>".
                "<td>".$row['username']."</td>".
                "<td>".BitToText($row['administrator'])."</td>".
                "<td>".BitToText($row['redaktor'])."</td>".
                "<td>".BitToText($row['recenzent'])."</td>";
            if ($_SESSION['adm'] == 1) {
                echo "<td><a href=\"?menu=users&u=view&user=".$row['username']."\">Otevřít</a></td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }
} ?>

<?php echo mysqli_error($link); ?>
