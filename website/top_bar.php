<div style="height: 125px;">
    <img src="img/VŠPJ.png" height="125px">
    LOGOS POLYTECHNIKOS
    <?php if (isset($_SESSION['logos_polytechnikos_login'])) : ?>
        <div style="float:right;">
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
