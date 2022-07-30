<?php
function delpoint($string)
{
	return str_replace("..", "", $string);
}
session_start();
if (isset($_SESSION["admin"]) && $_SESSION["admin"] == true) {
	//rcopy('files/' . delpoint($_GET["from"]), 'files/' . delpoint($_GET["to"]));
	echo 'ok';
}
else echo 'error';
function rrmdir($dir)
{
	if (is_dir($dir)) {
		$files = scandir($dir);
		foreach ($files as $file)
			if ($file != "." && $file != "..") rrmdir("$dir/$file");
		rmdir($dir);
	} else if (file_exists($dir)) unlink($dir);
}
// Function to copy folders and files       
function rcopy($src, $dst)
{
	if (file_exists($dst))
		rrmdir($dst);
	if (is_dir($src)) {
		mkdir($dst);
		$files = scandir($src);
		foreach ($files as $file)
			if ($file != "." && $file != "..")
				rcopy("$src/$file", "$dst/$file");
	} else if (file_exists($src))
		copy($src, $dst);
}