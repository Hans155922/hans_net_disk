<?php
$admin = false;
$name=$_POST['username'];
$pwd=$_POST['password'];
if($name=="admin"&&$pwd=="hans155922"){
    //  当验证通过后，启动 Session
    session_start();
    $_SESSION["admin"] = true;
    header('Location: /');
    exit;
}
else if($name=="user"&&$pwd=="user"){
    //  当验证通过后，启动 Session
    session_start();
    $_SESSION["user"] = true;
    header('Location: /');
    exit;
}
else if($name=="root"&&$pwd=="root"){
    //  当验证通过后，启动 Session
    session_start();
    $_SESSION["share"] = true;
    header('Location: /');
    exit;
}
else{
    echo "<script>alert('密码错误，请重新输入');location='login.html'</script>";
};