<?php
function BitToText($bit)
{
    if ($bit == 1) {
        return "Ano";
    } elseif ($bit == 0) {
        return "Ne";
    } elseif ($bit == -1) {
        return "nerozhodnuto";
    } else {
        return "err";
    }
}

function CheckboxToBit($checkbox)
{
    if (isset($checkbox)) {
        return '1';
    } else {
        return '0';
    }
}

function MailTo($to, $subject, $message)
{
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=iso-8859-1';

    mail($to, $subject, $message, implode("\r\n", $headers));
}
 ?>
