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

    $link = mysqli_connect("127.0.0.1", "zelenk11", "Mor92Bud", "zelenk11");
    mysqli_set_charset($link, "utf8");

    session_start();

    if (isset($_POST['logout'])) {
        session_destroy();
        header("Refresh:0");
    }

    if (isset($_POST['login_submit'])) {
        $query_login = "SELECT * FROM rsp_users WHERE username = '".$_POST['username']."' AND password = '".$_POST['password']."';";
        $sql_login = mysqli_query($link, $query_login);
        $login_num_rows = mysqli_num_rows($sql_login);
        $login_assoc = mysqli_fetch_assoc($sql_login);
        if ($login_num_rows == 1) {
            $_SESSION['logos_polytechnikos_login'] = $login_assoc['username'];

            $_SESSION['logos_polytechnikos_role'] = "";
            $_SESSION['adm'] = 0;
            $_SESSION['red'] = 0;
            $_SESSION['rec'] = 0;

            if ($login_assoc['administrator'] == 1) {
                $_SESSION['logos_polytechnikos_role'] .= "Administrátor<br>";
                $_SESSION['adm'] = 1;
            }
            if ($login_assoc['redaktor'] == 1) {
                $_SESSION['logos_polytechnikos_role'] .= "Redaktor<br>";
                $_SESSION['red'] = 1;
            }
            if ($login_assoc['recenzent'] == 1) {
                $_SESSION['logos_polytechnikos_role'] .= "Recenzent<br>";
                $_SESSION['rec'] = 1;
            }
        }
    }

    include_once("top_bar.php");
    include_once("basic_functions.php");

    if (!isset($_SESSION['logos_polytechnikos_login'])) : ?>
    <div style="border: 5px solid #ccc; border-radius: 25px; padding: 1em; margin: 10em; display: inline-block">
        <table>
            <form method="post">
                <tr>
                    <td>Jméno:</td>
                    <td><input type="text" name="username" class="form-control"></td>
                </tr>
                <tr>
                    <td>Heslo:</td>
                    <td><input type="password" name="password" class="form-control"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="login_submit" value="Přihlásit" class="form-control"></td>
                </tr>
            </form>
        </table>
    </div>
    <?php else :
        include_once("menu.php");

        if (isset($_GET['menu'])) {
            if ($_GET['menu'] == 'autori') {
                include_once("autori.php");
            } elseif ($_GET['menu'] == 'clanky') {
                if (isset($_GET['c'])) {
                    include_once("clanek.php");
                } else {
                    include_once("clanky.php");
                }
            } elseif ($_GET['menu'] == 'casopis') {
                include_once("casopis.php");
            } elseif ($_GET['menu'] == 'nastaveni') {
                include_once("nastaveni.php");
            } elseif ($_GET['menu'] == 'default') {
                include_once("default.php");
            } elseif ($_GET['menu'] == 'users') {
                include_once("users.php");
            }
        } else {
            include_once("default.php");
        }
    endif;
    ?>
</div>
