<head>
	<title>YummyMap</title>
	<link rel="stylesheet" type="text/css" href="../Map.css">
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
				echo "<script>alert('帳號不存在');location.href='../Info.html';</script>";
			}
			elseif ($sqlData->banned){
				//確認使否封鎖
				echo "<script>alert('此帳號已被封鎖');location.href='../Info.html';</script>";
			}
			elseif (!password_verify($password, '$2y$11$'.($sqlData->password))){
				echo "<script>alert('密碼錯誤');location.href='../Info.html';</script>";
				exit;
			}
			else {
				$_SESSION['account'] = $account;
				$_SESSION['user'] = 'Store';
			}
			
			$sql01->close();
		}
		else $account = $_SESSION['account'];
		
		echo "<h2>$account 的設定頁面 <input type='button' value='登出' onclick=\"javascript:location.href='./Logout.php'\"'></h2>";
		
		//紀錄最後登入時間
		$datetime = (new Datetime("now",  new DateTimeZone('Asia/Taipei')))->format("Y/m/d");
		$mysqli->query("UPDATE storeaccount SET lastLogin='$datetime' WHERE account='$account';");
		
		echo "<table width='400'><tr><td>ID</td><td align='center'>name</td><td>Method</td><td>Last Modified</td></tr>";
		$sql02 = $mysqli->query("SELECT storeIDs FROM storeaccount WHERE account='$account'");
		$sqlData = $sql02->fetch_object();
		$aStoreIDs = $sqlData->storeIDs;
		//判斷: 1.以防帳號沒有商家(ID)  2.登入者為管理員要轉址
		if ($aStoreIDs == ''){
			echo "<tr><td></td><td align='center'>暫無資料</td><td></td><td></td></tr></table>";
		}
		elseif ($aStoreIDs[0] == '0'){
			$_SESSION['user'] = 'Manager';
			header('Location: ./ManagerPage.php');
			exit;
		}
		else {
			$aStoreIDs = explode('@', $aStoreIDs);
			foreach ($aStoreIDs as $ID){
				$sql = $mysqli->query("SELECT id, name, lastModified FROM storeinfo WHERE id=$ID;");
				$sqlData = $sql->fetch_object();
				echo "<tr><td>".$ID."</td><td align='center'>".$sqlData->name ."</td><td><a href='./StoreInfo/Update.php?SelectId=".$ID."'> 編輯 </a><a href='./StoreInfo/Delete.php?SelectId=".$ID."'> 刪除 </a></td><td>".$sqlData->lastModified ."</td></tr>";
				$sql->close();
			}
			echo "</table>";
		}
		
		echo "<p><a href='./StoreInfo/Insert.html'>新增...</a></p>";
		
		$sql02->close();
		$mysqli->close();
	?>
</body>
