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
	class upload
	{
		private $path = 'tmp/'; //临时文件存放目录
		function uploadFile()
		{
			if (empty($_POST['upload_name']) || empty($_POST['number'])) {
				die(json_encode(array('error' => 202, 'message' => 'No parameters!')));
			}
			$name = $_POST['upload_name'];
			$nowShardNumber = $_POST['number'];
			$fileName = $this->path . $name . $nowShardNumber . ".tmp";
			$result = move_uploaded_file($_FILES['data']['tmp_name'], $fileName);
			if ($result) {
				echo json_encode(array('error' => 200, 'message' => 'Upload ok'));
			} else {
				echo json_encode(array('error' => 201, 'message' => 'Upload error'));
			}
		}
		function merge()
		{
			if (empty($_POST['upload_name']) || empty($_POST['numbers'])) {
				die(json_encode(array('error' => 202, 'message' => 'No parameters!')));
			}
			$fileName = $_POST['upload_name']; //文件名
			$allShardNumber = $_POST['numbers']; //文件总片数
			if (file_exists($fileName)) {
				unlink($fileName); //删除已经存在的完整文件
			}
			for ($i = 1; $i <= $allShardNumber; $i++) {
				$shardFile = $this->path . $fileName . $i . '.tmp';
				if (file_exists($shardFile)) {
					file_put_contents($this->path . $fileName, file_get_contents($shardFile), FILE_APPEND); //file_put_contents默认的是重写文件加上FILE_APPEND为追加写入
					@unlink($shardFile); //删除临时文件
				} else {
					break;
				}
			}
			echo json_encode(array('error' => 200, 'message' => 'Merge successful!'));
		}
	}
	if (isset($_GET['action'])) {
		$obj = new upload();
		if ($_GET['action'] === 'upload') {
			$obj->uploadFile();
		} else {
			$obj->merge();
		}
	} else {
		echo json_encode(array('error' => -1, 'message' => 'Error!'));
	}
}