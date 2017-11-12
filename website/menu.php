<nav class="navbar navbar-default">
    <div class="container-fluid">
        <ul class="nav navbar-nav">
            <li <?php if ($_GET['menu'] == 'default') echo 'class="active"'; ?>><a href="?menu=default">Titulní strana</a></li>
            <li <?php if ($_GET['menu'] == 'autori') echo 'class="active"'; ?>><a href="?menu=autori">Autoři</a></li>
            <li <?php if ($_GET['menu'] == 'clanky') echo 'class="active"'; ?>><a href="?menu=clanky">Články</a></li>
            <li <?php if ($_GET['menu'] == 'casopis') echo 'class="active"'; ?>><a href="?menu=casopis">Časopis</a></li>

            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Uživatelé<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="?menu=users&amp;u=add">Přidat uživatele</a></li>
                    <li><a href="?menu=users&amp;u=view">Zobrazit uživatele</a></li>
                </ul>
            </li>

            <li <?php if ($_GET['menu'] == 'nastaveni') echo 'class="active"'; ?>><a href="?menu=nastaveni">Nastavení</a></li>
        </ul>
    </div>
</nav>
