<?php
session_start();
//  这种方法是将原来注册的某个变量销毁
if (isset($_SESSION["admin"]) && $_SESSION["admin"] == true) unset($_SESSION['admin']);
else if (isset($_SESSION["user"]) && $_SESSION["user"] == true) unset($_SESSION['user']);
else if (isset($_SESSION["share"]) && $_SESSION["share"] == true) unset($_SESSION['share']);
//  这种方法是销毁整个 Session 文件
session_destroy();
echo 'bye';