<div style="height: 125px; background-color: #8f0e07;">
    <img src="img/logo.PNG" height="125px" style="margin-left: 50px;">
    <?php if (isset($_SESSION['logos_polytechnikos_login'])) : ?>
        <div style="float:right; background-color: white; height: 100%; padding: 5px;">
            <table>
                <tr><td><b><?php echo $_SESSION['logos_polytechnikos_login']; ?></b></td></tr>
                <tr><td><?php echo $_SESSION['logos_polytechnikos_role']; ?></td></tr>
                <tr>
                    <td>
                        <form method="post" action="">
                            <input type="submit" name="logout" value="Odhlásit">
                        </form>
                    </td>
                </tr>
            </table>
        </div>
    <?php endif; ?>
</div>
