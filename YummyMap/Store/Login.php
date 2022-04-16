<?php session_start();
	//確認是否登入 (避免重複登入)
	if (isset($_SESSION['account'])) header('Location: ./SettingPage.php');
?>
<head>
	<title>YummyMap</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="../Map.css">
</head>

<body id="InfoBody">
	<section class="InfoBK" id="Login">
		<h2>登入</h2>
		<form action="./SettingPage.php" method="post">
			<p>帳號- <input type="text" name="account" autocomplete="off"></p>
			<p>密碼- <input type="text" name="password" autocomplete="off"></p>
			<input type="submit" value="登入">
		</form>
	</section>
</body>
