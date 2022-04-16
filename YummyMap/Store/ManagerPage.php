<head>
	<title>YummyMap</title>
	<link rel="stylesheet" type="text/css" href="../Map.css">
	<script>
		function RenameBackup(target){
			var NewName = prompt("請輸入要更改成什麼名子 (" + target + ")");
			document.location.href= './Backup/RenameBackup.php?SelectFile=' + target + '&NewName=' + NewName;
		}
	</script>
</head>
<body>
	<?php session_start();
		$ManagerAccount = $_SESSION['account'];
		echo "<h2> $ManagerAccount 的管理頁面 <input type='button' value='登出' onclick=\"javascript:location.href='./Logout.php'\"'></h2>";
		
		$mysqli = new mysqli('localhost', 'Manager', 'MapManager0556', 'yummymap');
		if (mysqli_connect_error()){
			echo "連結錯誤訊息: ".mysqli_connect_error()."<br>";
			exit;
		}
		$sql01 = $mysqli->query("SELECT id, name, lastModified FROM storeinfo ORDER By id");
		
		echo "<table width='400'><tr><td>ID</td><td align='center'>name</td><td>Method</td><td>Last Modified</td></tr>";
		//以防帳號沒有商家(ID)
		if ($sql01->num_rows == ''){
			echo "<tr><td></td><td align='center'>暫無資料</td><td></td><td></td></tr></table>";
		}
		else {
			while ($sqlData = $sql01->fetch_object()){
				$ID = $sqlData->id;
				echo "<tr><td>".$ID."</td><td align='center'>".$sqlData->name ."</td><td><a href='./StoreInfo/Update.php?SelectId=".$ID."'> 編輯 </a><a href='./StoreInfo/Delete.php?SelectId=".$ID."'> 刪除 </a></td><td>".$sqlData->lastModified ."</td></tr>";
			}
			echo "</table>";
		}
		$sql01->close();
		echo "<p><a href='./StoreInfo/Insert.html'>新增...</a></p>";
		
		//管理商家帳戶
		$sql02 = $mysqli->query("SELECT * FROM storeaccount ORDER By account");
		echo "<hr><table width='500'><tr><td>Account</td><td align='center'>商家資料編號</td><td>Method</td><td>Last Login</td></tr>";
		if ($sql02->num_rows == '') echo "<tr><td></td><td align='center'>暫無資料</td><td></td><td></td></tr></table>";
		else {
			while ($sqlData = $sql02->fetch_object()){
				$account = $sqlData->account;
				$IDs = str_replace('@' , ' ', $sqlData->storeIDs);
				
				//Method 不對自己作用
				if ($account == $ManagerAccount){
					echo "<tr><td>".$account ."</td><td align='center'>".$IDs."</td><td></td><td>".$sqlData->lastLogin ."</td></tr>";
					continue;
				}
				
				echo "<tr><td>".$account."</td><td align='center'>".$IDs."</td><td><a href='./StoreAccount/EditStoreInfo.php?SelectAccount=".$account."'> 編輯 </a>".(($sqlData->banned == 1)? "<a href='./StoreAccount/InputData.php?SelectAccount=".$account."&Method=Unlock'> 解鎖 </a>" : "<a href='./StoreAccount/InputData.php?SelectAccount=".$account."&Method=Ban'> 封鎖 </a>")."<a href='./StoreAccount/InputData.php?SelectAccount=".$account."&Method=Delete'> 刪除 </a></td><td>".$sqlData->lastLogin ."</td></tr>";
			}
			echo "</table>";
		}
		$sql02->close();
		

		// 因為資料庫更新，導致有一些 Bug 要處理 (Backup.YummyMap -> YummyMap.Backup)
		// //版本管理與備份(日更，管理員登入時檢查更新)
		// $datetime = (new Datetime("now",  new DateTimeZone('Asia/Taipei')))->format("Y.m.d");
		// $IsBackup = 0;
		// $HaveAnything = 2;
		// echo "<hr><p><input type='button' value='手動備份' onclick='javascript:location.href=\"./Backup/ManualBackup.php?SelectFile=__Nobody__\"'></p>";
		// echo "<table width='300'><tr><td>File</td><td> Method </td></tr>";

		// 	//手動更新
		// $sql03 = $mysqli->query("SELECT file FROM backup WHERE form = 'Manual' ORDER By file;");
		// if ($sql03->num_rows == '') $HaveAnything -= 1;
		// else {
		// 	while ($sqlData = $sql03->fetch_object()){
		// 		$fileVersion = $sqlData->file;
		// 		echo "<tr><td>".$fileVersion."</td><td><a href='./Backup/UseVersion.php?SelectFile=Manual_".$fileVersion."'> 使用 </a><a href='./Backup/ManualBackup.php?SelectFile=".$fileVersion."'> 存自此 </a><a href='javascript:void(0)' onclick='RenameBackup(\"".$fileVersion."\")'> 命名 </a><a href='./Backup/DeleteBackup.php?SelectFile=".$fileVersion."'> 刪除 </a></td></tr>";
		// 	}
		// }
		
		// 	//系統更新
		// $sql04 = $mysqli->query("SELECT file FROM backup WHERE form = 'System' ORDER By file;");
		// if ($sql04->num_rows == '') $HaveAnything -= 1;
		// else {
		// 	while ($sqlData = $sql04->fetch_object()){
		// 		$fileVersion = $sqlData->file;
		// 		echo "<tr><td>".$fileVersion."</td><td><a href='./Backup/UseVersion.php?SelectFile=".$fileVersion."'> 使用 </a></td></tr>";
				
		// 		if ($fileVersion == $datetime) $IsBackup = 1;
		// 	}
		// }

		// if ($HaveAnything == 0) echo "<tr><td align='center'>暫無資料</td></tr>";
		// echo "</table>";
		// if ($IsBackup == 0) header('Location: ./Backup/SystemBackup.php'); #php.ini -> output_buffering=On
		
		
		$mysqli->close();
	?>
</body>
