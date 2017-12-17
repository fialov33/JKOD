<?php
if (isset($_GET['order'])) {
    if ($_GET['order'] == 'autor_mail') {
        $sql_load_autori = "SELECT autor_mail, COUNT(autor_mail) FROM rsp_autori GROUP BY autor_mail ORDER BY autor_mail";
        if (isset($_GET['o'])) {
            $sql_load_autori .= " DESC";
        }
    } elseif ($_GET['order'] == 'count_autor') {
        $sql_load_autori = "SELECT autor_mail, COUNT(autor_mail) FROM rsp_autori GROUP BY autor_mail ORDER BY COUNT(autor_mail)";
        if (isset($_GET['o'])) {
            $sql_load_autori .= " DESC";
        }
    } elseif ($_GET['order'] == 'count_accepted') {
# TODO razeni count accepted
        $sql_load_autori = "SELECT autor_mail, COUNT(autor_mail) FROM rsp_autori GROUP BY autor_mail";
    }
} else {
    $sql_load_autori = "SELECT autor_mail, COUNT(autor_mail) FROM rsp_autori GROUP BY autor_mail";
}

$query_load_autori = mysqli_query($link, $sql_load_autori);

?>

<table class="table table-striped">
    <thead>
        <tr>
            <td>
                <b>
                    <a href="?menu=autori&amp;order=autor_mail<?php if (@$_GET['order'] == 'autor_mail' && !isset($_GET['o'])) echo '&o=desc'; ?>">
                        E-mail
                    </a>
                </b>
            </td>
            <td>
                <b>
                    <a href="?menu=autori&amp;order=count_autor<?php if (@$_GET['order'] == 'count_autor' && !isset($_GET['o'])) echo '&o=desc'; ?>">
                        Počet příspěvků
                    </a>
                </b>
            </td>
            <td>
                <b>
                    <a href="?menu=autori&amp;order=count_accepted<?php if (@$_GET['order'] == 'count_accepted' && !isset($_GET['o'])) echo '&o=desc'; ?>">
                        Počet vydaných článků
                    </a>
                </b>
            </td>
        </tr>
    </thead>
    <?php
    $autori_info = array();
    while ($row = mysqli_fetch_assoc($query_load_autori)) {
        $sql_load_uznane = "SELECT * FROM rsp_autori WHERE autor_mail = '".$row['autor_mail']."' AND prijato = '1'";
        $count_uznane = mysqli_num_rows(mysqli_query($link, $sql_load_uznane));

        echo
        "<tr>" .
        "<td><a href=\"?menu=clanky&amp;autor_mail=".$row['autor_mail']."\">". $row['autor_mail'] ."</td>".
        "<td>". $row['COUNT(autor_mail)'] ."</td>".
        "<td>". $count_uznane ."</td>".
        "</tr>";
    }

     ?>
</table>
