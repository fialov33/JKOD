<?php
function BitToText($bit)
{
    if ($bit == 1) {
        return "Ano";
    } elseif ($bit == 0) {
        return "Ne";
    } else {
        return "err";
    }
}
 ?>
