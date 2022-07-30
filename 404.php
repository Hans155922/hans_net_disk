<?php
echo '<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>你是个很好的测试工程师</title>
<!--网页标题左侧显示-->
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<!--收藏夹显示图标-->
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<style>
	body{
		background-color:#444;
		font-size:14px;
	}
	h3{
		font-size:60px;
		color:#eee;
		text-align:center;
		padding-top:30px;
		font-weight:normal;
	}
	h4{
		font-size:40px;
		color:#eee;
		text-align:center;
		padding-top:60px;
		font-weight:normal;
	}
</style>
</head>
<body>
<h3>谢谢你，你是个很好的测试工程师</h3>
<h4>';
echo '请求路径:'.$_SERVER["REQUEST_URI"];
echo '</h4
</body>
</html>';