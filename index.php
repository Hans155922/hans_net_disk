<?php
function delpoint($string)
{
    return str_replace("..", "", $string);
}
function size($filesize)
{
    $return = 'Byte';
    if ($filesize >= 1024) {
        $filesize = $filesize / 1024;
        $return = "KB";
    } else return $filesize . $return;
    if ($filesize >= 1024) {
        $filesize = $filesize / 1024;
        $return = "MB";
    } else return $filesize . $return;
    if ($filesize >= 1024) {
        $filesize = $filesize / 1024;
        $return = "GB";
    } else return $filesize . $return;
    if ($filesize >= 1024) {
        $filesize = $filesize / 1024;
        $return = "TB";
    } else return $filesize . $return;
}
function paixu($filename, $User_level)
{
    $return = "";
    switch ($_GET["sort"]) {
        case 1: //按文件名升序
            array_multisort($filename, SORT_ASC, SORT_STRING);
            break;
        case 2: //按文件名降序
            array_multisort($filename, SORT_DESC, SORT_STRING);
            break;
        case 3: //按文件大小升序
            $a = 0;
            foreach ($filename as $val) {  // 遍历数组
                $filesize[] = filesize('files/' . delpoint($_GET["path"]) . '/' . $filename[$a]);
                $a++;
            }
            array_multisort($filesize, SORT_ASC, SORT_NUMERIC, $filename);
            break;
        case 4: //按文件大小降低序
            $a = 0;
            foreach ($filename as $val) {  // 遍历数组
                $filesize[] = filesize('files/' . delpoint($_GET["path"]) . '/' . $filename[$a]);
                $a++;
            }
            array_multisort($filesize, SORT_DESC, SORT_NUMERIC, $filename);
            break;
        case 5: //按文件日期升序
            $a = 0;
            foreach ($filename as $val) {  // 遍历数组
                $filemtime[] = filemtime('files/' . delpoint($_GET["path"]) . '/' . $filename[$a]);
                $a++;
            }
            array_multisort($filemtime, SORT_ASC, SORT_NUMERIC, $filename);
            break;
            break;
        case 6: //按文件日期降序
            $a = 0;
            foreach ($filename as $val) {  // 遍历数组
                $filemtime[] = filemtime('files/' . delpoint($_GET["path"]) . '/' . $filename[$a]);
                $a++;
            }
            array_multisort($filemtime, SORT_DESC, SORT_NUMERIC, $filename);
            break;
            break;
        default: //其他
            array_multisort($filename, SORT_ASC, SORT_STRING); //按名字排序
    }
    if (is_file('files/' . delpoint($_GET["path"]) . '/' . $filename[0])) {
        $a = 0;
        foreach ($filename as $val) {  // 遍历数组
            echo '<tr><td><a href="download.php?file=' . $_GET["path"] . '/' . urlencode($filename[$a]) . '"><img src="icon/file.png" height="20" />' . $filename[$a] . '</a></td>';
            echo '<td>' . size(filesize('files/' . delpoint($_GET["path"]) . '/' . $filename[$a])) . '</td>';
            echo '<td>' . date('Y-m-d H:i:s', filemtime('files/' . delpoint($_GET["path"]) . '/' . $filename[$a])) . '</td>';
            if ($User_level < 1) echo '<td>' . '</td>';
            if ($User_level < 1) echo '<td><button type="button" class="layui-btn" onclick="del(\'' . $filename[$a] . '\',\'' . delpoint($_GET["path"]) . '\')">删除</button></td>';
            else echo '<td><a href="download.php?file=' . $_GET["path"] . '/' . urlencode($filename[$a]) . '"><button type="button" class="layui-btn">下载</button></a></td>';
            echo '</tr>';
            $a++;
        }
    } else {
        $a = 0;
        foreach ($filename as $val) {  // 遍历数组
            echo '<tr><td><a href="?path=' . $_GET["path"] . '/' . urlencode($filename[$a]) . '&sort=' . $_GET["sort"] . '"><img src="icon/folder.png" height="20" />' . $filename[$a] . '</a></td>';
            //echo '<td>' . filesize('files/' . $filename[$a]) . '</td>';
            echo '<td>---</td>';
            echo '<td>' . date('Y-m-d H:i:s', filemtime('files/' . delpoint($_GET["path"]) . '/' . $filename[$a])) . '</td>';
            if ($User_level < 1) echo '<td>' . '</td>';
            if ($User_level < 1) echo '<td><button type="button" class="layui-btn" onclick="del(\'' . $filename[$a] . '\',\'' . delpoint($_GET["path"]) . '\')">删除</button></td>';
            else echo '<td>' . '</td>';
            echo '</tr>';
            $a++;
        }
    }
}
function fileShow($path, $User_level)
{ //遍历目录下的所有文件和文件夹
    $fullpath = 'files/' . $path;
    if (file_exists($fullpath)) {
        $handle = opendir($fullpath);
        while ($file = readdir($handle)) {
            if ($file !== '..' && $file !== '.') {
                $f = $fullpath . '/' . $file;
                if (is_file($f)) {
                    $files[] = $file;
                } else {
                    $folders[] = $file;
                }
            }
        }
        if ($files != '') {
            paixu($files, $User_level);
        }
        if ($folders != '') {
            paixu($folders, $User_level);
        }
        if ($files == '' && $folders == '') {
            echo '当前文件夹为空';
        }
    } else {
        echo "文件夹不存在";
    }
    echo '</body></html>';
}
session_start();
if (isset($_SESSION["admin"]) && $_SESSION["admin"] == true) $User_level = 0;
else if (isset($_SESSION["user"]) && $_SESSION["user"] == true) $User_level = 1;
else if (isset($_SESSION["share"]) && $_SESSION["share"] == true) $User_level = 2;
else {
    header('Location: login.html');
    exit;
}
if ($User_level >= 0) {
    echo '<html><head><meta charset="utf-8"><title>函数网盘</title><!--网页标题左侧显示--><link rel="icon" href="/favicon.ico" type="image/x-icon"><!--收藏夹显示图标--><link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"><script src="layui.js";></script>';
    if ($User_level < 2) echo '<script src="upload.js";></script><script src="creatfolder.js";></script>';
    if ($User_level < 1) echo '<script src="delete.js";></script>';
    echo '<script src="exit.js";></script><script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.6.0/jquery.min.js"></script><link rel="stylesheet" href="layui.css";></head><body><a href="?path=';
    if (dirname(delpoint($_GET["path"])) != '\\') echo dirname($_GET["path"]);
    echo '&sort=' . $_GET["sort"] . '"><button type="button" class="layui-btn">返回上一级</button></a>';
    $path = delpoint($_GET["path"]);
    switch ($_GET["sort"]) {
        case 1: //按文件名升序
            echo '<button class="layui-btn layui-btn-primary layui-border-green">按文件名升序</button>';
            echo '<a href="?path=' . $path . '&sort=2"><button type="button" class="layui-btn">按文件名降序</button></a>';
            echo '<a href="?path=' . $path . '&sort=3"><button type="button" class="layui-btn">按文件大小升序</button></a>';
            echo '<a href="?path=' . $path . '&sort=4"><button type="button" class="layui-btn">按文件大小降序</button></a>';
            echo '<a href="?path=' . $path . '&sort=5"><button type="button" class="layui-btn">按文件日期升序</button></a>';
            echo '<a href="?path=' . $path . '&sort=6"><button type="button" class="layui-btn">按文件日期降序</button></a>';
            break;
        case 2: //按文件名降序
            echo '<a href="?path=' . $path . '&sort=1"><button type="button" class="layui-btn">按文件名升序</button></a>';
            echo '<button class="layui-btn layui-btn-primary layui-border-green">按文件名降序</button>';
            echo '<a href="?path=' . $path . '&sort=3"><button type="button" class="layui-btn">按文件大小升序</button></a>';
            echo '<a href="?path=' . $path . '&sort=4"><button type="button" class="layui-btn">按文件大小降序</button></a>';
            echo '<a href="?path=' . $path . '&sort=5"><button type="button" class="layui-btn">按文件日期升序</button></a>';
            echo '<a href="?path=' . $path . '&sort=6"><button type="button" class="layui-btn">按文件日期降序</button></a>';
            break;
        case 3: //按文件大小升序
            echo '<a href="?path=' . $path . '&sort=1"><button type="button" class="layui-btn">按文件名升序</button></a>';
            echo '<a href="?path=' . $path . '&sort=2"><button type="button" class="layui-btn">按文件名降序</button></a>';
            echo '<button class="layui-btn layui-btn-primary layui-border-green">按文件大小升序</button>';
            echo '<a href="?path=' . $path . '&sort=4"><button type="button" class="layui-btn">按文件大小降序</button></a>';
            echo '<a href="?path=' . $path . '&sort=5"><button type="button" class="layui-btn">按文件日期升序</button></a>';
            echo '<a href="?path=' . $path . '&sort=6"><button type="button" class="layui-btn">按文件日期降序</button></a>';
            break;
        case 4: //按文件大小降序
            echo '<a href="?path=' . $path . '&sort=1"><button type="button" class="layui-btn">按文件名升序</button></a>';
            echo '<a href="?path=' . $path . '&sort=2"><button type="button" class="layui-btn">按文件名降序</button></a>';
            echo '<a href="?path=' . $path . '&sort=3"><button type="button" class="layui-btn">按文件大小升序</button></a>';
            echo '<button class="layui-btn layui-btn-primary layui-border-green">按文件大小降序</button>';
            echo '<a href="?path=' . $path . '&sort=5"><button type="button" class="layui-btn">按文件日期升序</button></a>';
            echo '<a href="?path=' . $path . '&sort=6"><button type="button" class="layui-btn">按文件日期降序</button></a>';
            break;
        case 5: //按文件日期升序
            echo '<a href="?path=' . $path . '&sort=1"><button type="button" class="layui-btn">按文件名升序</button></a>';
            echo '<a href="?path=' . $path . '&sort=2"><button type="button" class="layui-btn">按文件名降序</button></a>';
            echo '<a href="?path=' . $path . '&sort=3"><button type="button" class="layui-btn">按文件大小升序</button></a>';
            echo '<a href="?path=' . $path . '&sort=4"><button type="button" class="layui-btn">按文件大小降序</button></a>';
            echo '<button class="layui-btn layui-btn-primary layui-border-green">按文件日期升序</button>';
            echo '<a href="?path=' . $path . '&sort=6"><button type="button" class="layui-btn">按文件日期降序</button></a>';
            break;
        case 6: //按文件日期降序
            echo '<a href="?path=' . $path . '&sort=1"><button type="button" class="layui-btn">按文件名升序</button></a>';
            echo '<a href="?path=' . $path . '&sort=2"><button type="button" class="layui-btn">按文件名降序</button></a>';
            echo '<a href="?path=' . $path . '&sort=3"><button type="button" class="layui-btn">按文件大小升序</button></a>';
            echo '<a href="?path=' . $path . '&sort=4"><button type="button" class="layui-btn">按文件大小降序</button></a>';
            echo '<a href="?path=' . $path . '&sort=5"><button type="button" class="layui-btn">按文件日期升序</button></a>';
            echo '<button class="layui-btn layui-btn-primary layui-border-green">按文件日期降序</button>';
            break;
        default: //其他
            $sort = 1;
            echo '<button class="layui-btn layui-btn-primary layui-border-green">按文件名升序</button>';
            echo '<a href="?path=' . $path . '&sort=2"><button type="button" class="layui-btn">按文件名降序</button></a>';
            echo '<a href="?path=' . $path . '&sort=3"><button type="button" class="layui-btn">按文件大小升序</button></a>';
            echo '<a href="?path=' . $path . '&sort=4"><button type="button" class="layui-btn">按文件大小降序</button></a>';
            echo '<a href="?path=' . $path . '&sort=5"><button type="button" class="layui-btn">按文件日期升序</button></a>';
            echo '<a href="?path=' . $path . '&sort=6"><button type="button" class="layui-btn">按文件日期降序</button></a>';
    }
    if ($User_level < 2) echo '<button type="button" class="layui-btn" style="margin-left:0px" onclick="creatfolder(\'' . $path . '\');">新建文件夹</button>';
    //if ($User_level < 2)echo '<button type="button" class="layui-btn" style="margin-left:0px">新建文件</button>';
    if ($User_level < 2)echo '<button type="button" class="layui-btn" id="upload" onclick="layer.use" style="margin-left:0px">上传文件</button><button type="button" class="layui-btn" style="margin-left:0px">复制</button><button type="button" class="layui-btn" style="margin-left:0px">剪切</button>';
    if ($User_level < 1) echo '<a href="recycle.php"><button type="button" class="layui-btn">回收站</button></a>';
    echo '<button type="button" class="layui-btn" onclick="exit();" style="margin-left:0px">退出</button>';
    if ($User_level < 1) echo '<table class="layui-table" lay-skin="line"><colgroup><col width="300"><col width="50"><col width="200"><col width="50"><col width="50"></colgroup><thead><tr><th>文件名</th><th>文件大小</th><th>修改时间</th><th>重命名</th><th>删除</th></tr></thead><tbody>';
    else echo '<table class="layui-table" lay-skin="line"><colgroup><col width="300"><col width="50"><col width="200"><col width="50"></colgroup><thead><tr><th>文件名</th><th>文件大小</th><th>修改时间</th><th>下载</th></tr></thead><tbody>';
    fileShow(delpoint($_GET["path"]), $User_level);
    echo '</tbody></table></body></html></br>';
}
