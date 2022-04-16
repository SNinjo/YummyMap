<!-- Class 配合 Ajax 比較好整理，才不用一直跳網頁
-->

<head>
	<title>YummyMap</title>
	<link rel="stylesheet" type="text/css" href="../../Map.css">
</head>
<body>
	<?php session_start();
		$mysqli = new mysqli('localhost', 'Store', 'StoreSelf', 'yummymap');
		if (mysqli_connect_error()){
			echo "連結錯誤訊息: ".mysqli_connect_error()."<br>";
			exit;
		}
		
		//判斷是否登入 (Session 儲存登入帳號)
		if (isset($_POST['account'])){
			$account = $_POST['account'];
			$password = $_POST['password'];
			
			//驗證帳密
			$sql01 = $mysqli->query("SELECT storeIDs, banned, password FROM storeaccount WHERE account='$account';");
			$sqlData = $sql01->fetch_object();
			if ($sql01->num_rows == ''){
				echo "<script>alert('帳號不存在');location.href='http://127.0.0.1/MyWebsite/YummyMap/Info.html';</script>";
			}
			elseif ($sqlData->banned){
				//確認使否封鎖
				echo "<script>alert('此帳號已被封鎖');location.href='http://127.0.0.1/MyWebsite/YummyMap/Info.html';</script>";
			}
			elseif (!password_verify($password, '$2y$11$'.($sqlData->password))){
				echo "<script>alert('密碼錯誤');location.href='http://127.0.0.1/MyWebsite/YummyMap/Info.html';</script>";
				exit;
			}
			else {
				$_SESSION['account'] = $account;
				$_SESSION['user'] = 'Store';
			}
			
			$sql01->close();
		}
		else $account = $_SESSION['account'];

		//紀錄最後登入時間
		$datetime = (new Datetime("now",  new DateTimeZone('Asia/Taipei')))->format("Y/m/d");
		$mysqli->query("UPDATE storeaccount SET lastLogin='$datetime' WHERE account='$account';");
		
		include 'Class_User.php';
		$user = new User;
		$user->Show($mysqli);

		$mysqli->close();
	?>
</body>
