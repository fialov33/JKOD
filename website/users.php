<?php
if (isset($_POST['uzivatel_add'])) {
    $query_user_add = "INSERT INTO rsp_users VALUES ('".$_POST['username']."', '".$_POST['password']."', '".CheckboxToBit(@$_POST['adm'])."', '".CheckboxToBit(@$_POST['red'])."', '".CheckboxToBit(@$_POST['rec'])."');";
    $sql_user_add = mysqli_query($link, $query_user_add);
}
if (isset($_POST['uzivatel_change'])) {
    $query_user_change = "UPDATE rsp_users SET username = '".$_POST['username']."', password = '".$_POST['password']."', administrator = '".CheckboxToBit(@$_POST['adm'])."', redaktor = '".CheckboxToBit(@$_POST['red'])."', recenzent = '".CheckboxToBit(@$_POST['rec'])."' WHERE username = '".$_POST['username']."';";
    $sql_user_change = mysqli_query($link, $query_user_change);
}
if ($_GET['u'] == "add") :
    if ($_SESSION['adm'] == 1) : ?>
    <table class="table">
        <form method="post">
            <tr>
                <td colspan="2"><b>Přidání uživatele<b></td>
            </tr>
            <tr>
                <td>Uživatelské jméno</td>
                <td><input type="text" name="username" class="form-control"></td>
            </tr>
            <tr>
                <td>Heslo</td>
                <td><input type="text" name="password" class="form-control"></td>
            </tr>
            <tr>
                <td>Administrátor</td>
                <td><input type="checkbox" name="adm" class="form-control"></td>
            </tr>
            <tr>
                <td>Redaktor</td>
                <td><input type="checkbox" name="red" class="form-control"></td>
            </tr>
            <tr>
                <td>Recenzent</td>
                <td><input type="checkbox" name="rec" class="form-control"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="uzivatel_add" class="btn-default, btn"></td>
            </tr>
        </form>
    </table>
<?php else:
    echo "Nemáte oprávnění přidávat uživatele. Pokud si přejete přidat nového uživatele nebo měnit stávající kontaktujte prosím administrátora.";
    endif;
endif;

if ($_GET['u'] == "view") {
    if (isset($_GET['user'])) {
        $query_users = "SELECT * FROM rsp_users WHERE username = '".$_GET['user']."';";
        $sql_users = mysqli_query($link, $query_users);
        $user_assoc = mysqli_fetch_assoc($sql_users);
        ?>
        <table class="table">
            <form method="post" action="?menu=users&amp;u=view">
                <tr>
                    <td colspan="2"><b>Úprava uživatele</b></td>
                </tr>
                <tr>
                    <td>Uživatelské jméno</td>
                    <td><input type="text" name="username" value="<?php echo $user_assoc['username']; ?>" class="form-control"></td>
                </tr>
                <tr>
                    <td>Heslo</td>
                    <td><input type="text" name="password" value="<?php echo $user_assoc['password']; ?>" class="form-control"></td>
                </tr>
                <tr>
                    <td>Administrátor</td>
                    <td><input type="checkbox" name="adm" <?php if ($user_assoc['administrator'] == 1) echo "checked" ?>></td>
                </tr>
                <tr>
                    <td>Redaktor</td>
                    <td><input type="checkbox" name="red" <?php if ($user_assoc['redaktor'] == 1) echo "checked" ?>></td>
                </tr>
                <tr>
                    <td>Recenzent</td>
                    <td><input type="checkbox" name="rec" <?php if ($user_assoc['recenzent'] == 1) echo "checked" ?>></td>
                </tr>
                <?php if ($_SESSION['adm'] == 1) : ?>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="uzivatel_change" class="btn-default, btn"></td>
                    </tr>
                <?php endif; ?>
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
