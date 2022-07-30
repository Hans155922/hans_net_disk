<?php
function delpoint($string)
{
    return str_replace("..", "", $string);
}
session_start();
if (isset($_SESSION["admin"]) && $_SESSION["admin"] == true) $User_level = 0;
else if (isset($_SESSION["user"]) && $_SESSION["user"] == true) $User_level = 1;
else if (isset($_SESSION["share"]) && $_SESSION["share"] == true) $User_level = 2;
else {
	echo 'error';
	exit;
}
if ($User_level < 2) {
	if(rename('tmp/'.delpoint($_GET["from"]),'files/'.delpoint($_GET["path"])))echo 'ok';
	else echo 'error';
} 