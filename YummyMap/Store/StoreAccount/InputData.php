<?php session_start();
	$mysqli = new mysqli('localhost', 'Manager', 'MapManager0556', 'yummymap');
	if (mysqli_connect_error()){
		echo "連結錯誤訊息: ".mysqli_connect_error()."<br>";
		exit;
	}
	
	$account = $_GET['SelectAccount'];
	$ManagerAccount = $_SESSION['account'];
	$Method = $_GET['Method'];
	if ($Method == 'Edit'){
		$mysqli->query("UPDATE storeaccount SET storeIDs='".$_POST['managerIDs']."' WHERE account='$ManagerAccount'");
		$mysqli->query("UPDATE storeaccount SET storeIDs='".$_POST['storeIDs']."' WHERE account='$account'");
	}
	elseif ($Method == 'Ban'){
		$mysqli->query("UPDATE storeaccount SET banned=1 WHERE account='$account'");
	}
	elseif ($Method == 'Unlock'){
		$mysqli->query("UPDATE storeaccount SET banned=0 WHERE account='$account'");
	}
	elseif ($Method == 'Delete'){
		//將該帳號擁有的商家資料轉給此管理員
		$storeIDs = $mysqli->query("SELECT storeIDs FROM storeaccount WHERE account='$account'")->fetch_object()->storeIDs;
		$managerIDs = $mysqli->query("SELECT storeIDs FROM storeaccount WHERE account='$ManagerAccount'")->fetch_object()->storeIDs;
		if ($storeIDs != ''){
			$storeIDs = explode('@', $storeIDs);
			$managerIDs = explode('@', $managerIDs);
			$iNumStoreIDs = count($storeIDs);
			$iNumManagerIDs = count($managerIDs);
			$NewStoreIDs = $managerIDs[0];
			for ($i = 0, $x = 1; $i < $iNumStoreIDs and $x < $iNumManagerIDs;){
				if ($storeIDs[$i] < $managerIDs[$x]) $NewStoreIDs .= '@'.$storeIDs[$i++];
				else $NewStoreIDs .= '@'.$managerIDs[$x++];
			}
			if ($i != count($storeIDs)){
				for (; $i < $iNumStoreIDs; $i++) $NewStoreIDs .= '@'.$storeIDs[$i];
			}
			else for (; $x < $iNumManagerIDs; $x++) $NewStoreIDs .= '@'.$iNumManagerIDs[$x];
			$mysqli->query("UPDATE storeaccount SET storeIDs='$NewStoreIDs' WHERE account='$ManagerAccount'");
		}
		$mysqli->query("DELETE FROM storeaccount WHERE account='$account'");
	}
	echo "<script>alert('設定完成');location.href='../ManagerPage.php';</script>";
?>
