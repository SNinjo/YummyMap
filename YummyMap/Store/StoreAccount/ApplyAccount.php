<?php 
	$mysqli = new mysqli('localhost', 'Store', 'StoreSelf', 'yummymap');
	if (mysqli_connect_error()){
		echo "連結錯誤訊息: ".mysqli_connect_error()."<br>";
		exit;
	}
	
	$account = $_POST['account'];
	$password = $_POST['password'];
	$CheckPassword = $_POST['CheckPassword'];
	$sql01 = $mysqli->query("SELECT * FROM storeaccount WHERE account='$account';")->num_rows;
	if ($password != $CheckPassword){
		echo "<script>alert('兩次密碼輸入不相同');location.href='http://127.0.0.1/MyWebsite/YummyMap/Info.html';</script>";
	}
	elseif ($sql01 != ''){
		echo "<script>alert('帳號已存在');location.href='http://127.0.0.1/MyWebsite/YummyMap/Info.html';</script>";
	}
	else {
		//密碼加密 Bcrypt (Blowfish 和 crypt() 函式的結合)
		if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
			$salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
			//去頭($2y$11$)
			$Hash = substr(crypt($password, $salt), 7);
			echo crypt($password, $salt)."<br>";//
			echo $Hash;//
		}
		
		$mysqli->query("INSERT INTO storeaccount (account, password) VALUES ('$account', '$Hash');");
		echo "<script>alert('註冊成功');location.href='http://127.0.0.1/MyWebsite/YummyMap/Info.html';</script>";
	}
?>
