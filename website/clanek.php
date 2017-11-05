<?php
$query_load_clanky = "SELECT * FROM rsp_autori NATURAL JOIN rsp_casopisy WHERE rsp_autori.index = '".$_GET['c']."';";
$sql_clanky = mysqli_query($link, $query_load_clanky);

$sql_clanky_assoc = mysqli_fetch_array($sql_clanky, MYSQLI_ASSOC);
echo "<pre>"; print_r($sql_clanky_assoc); echo "</pre>";
 ?>

<embed src="http://195.113.207.171/~zelenk11/rsp/uploads/<?php echo $sql_clanky_assoc['index']; ?>.pdf" width="990" height="700" type='application/pdf'></embed>

schvalit clanek<br>
recenze 1<br>
recenze 2<br>
poslat email<br>
