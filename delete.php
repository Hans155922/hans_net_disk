<?php
function delpoint($string)
{
    return str_replace("..", "", $string);
}
session_start();
if (isset($_SESSION["admin"]) && $_SESSION["admin"] == true){
    $time = time();
    if (rename('files/' . delpoint($_GET["delete"]), 'recycle/' . $time)) ok($time);
    else echo 'error';
}
else echo 'error';
function ok($time)
{
    $log = fopen('recycle/' . $time . '.log', "w");
    fwrite($log, delpoint($_GET["delete"]));
    fclose($log);
    echo 'ok';
}