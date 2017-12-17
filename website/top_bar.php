<div style="height: 125px; background-color: #8f0e07;">
    <?php if (isset($_SESSION['logos_polytechnikos_login'])) : ?>
        <a href="main.php?menu=default">
            <img src="img/logo.PNG" height="125px" style="margin-left: 50px;">
        </a>
        <div style="float:right; background-color: white; height: 100%; padding: 5px;">
            <table>
                <tr><td><b><?php echo $_SESSION['logos_polytechnikos_login']; ?></b></td></tr>
                <tr><td><?php echo $_SESSION['logos_polytechnikos_role']; ?></td></tr>
                <tr>
                    <td>
                        <form method="post" action="">
                            <input type="submit" name="logout" value="Odhlásit" class="btn-default btn">
                        </form>
                    </td>
                </tr>
            </table>
        </div>
    <?php else: ?>
        <img src="img/logo.PNG" height="125px" style="margin-left: 50px;">
    <?php endif; ?>
</div>
