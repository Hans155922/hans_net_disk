<?php
session_start();
if (isset($_SESSION["admin"]) && $_SESSION["admin"] == true) $User_level = 0;
else if (isset($_SESSION["user"]) && $_SESSION["user"] == true) $User_level = 1;
else if (isset($_SESSION["share"]) && $_SESSION["share"] == true) $User_level = 2;
else {
    header('Location: login.html');
    exit;
}
if ($User_level >= 0) {
    function delpoint($string)
    {
        return str_replace("..", "", $string);
    }
    if (file_exists("files/" . delpoint($_GET["file"]))) {
        $downfile = "files/" . delpoint($_GET["file"]);
        header('Content-Description: File Transfer'); //描述页面返回的结果
        header('Content-Type: application/octet-stream'); //返回内容的类型，此处只知道是二进制流。具体返回类型可参考http://tool.oschina.net/commons
        header('Content-Disposition: attachment; filename=' . basename($downfile)); //可以让浏览器弹出下载窗口
        header('Content-Transfer-Encoding: binary'); //内容编码方式，直接二进制，不要gzip压缩
        header('Expires: 0'); //过期时间
        header('Cache-Control: must-revalidate'); //缓存策略，强制页面不缓存，作用与no-cache相同，但更严格，强制意味更明显
        header('Pragma: public');
        header('Content-Length: ' . filesize($downfile)); //文件大小，在文件超过2G的时候，filesize()返回的结果可能不正确
        while (ob_get_level()) ob_end_clean();
        //设置完header以后
        ob_clean();
        flush();  //清空缓冲区
        readfile($downfile);
    } else echo "文件不存在";
}
