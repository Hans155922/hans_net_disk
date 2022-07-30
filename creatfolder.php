<?php
function delpoint($string)
{
    return str_replace("..", "", $string);
}
session_start();
if (isset($_SESSION["admin"]) && $_SESSION["admin"] == true) $User_level = 0;
else if (isset($_SESSION["user"]) && $_SESSION["user"] == true) $User_level = 1;
else {
    echo 'error';
    exit;
}
if ($User_level < 2) {
    if (is_dir("files/".delpoint($_GET["name"]))) echo 'exist';
    else {
        mkdir("files/".delpoint($_GET["name"]),0777,true);
        echo 'ok';
    }
}