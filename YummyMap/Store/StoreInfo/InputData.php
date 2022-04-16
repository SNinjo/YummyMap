<?php session_start();
	$mysqli = new mysqli('localhost', 'Store', 'StoreSelf', 'yummymap');
	if (mysqli_connect_error()){
		echo "連結錯誤訊息: ".mysqli_connect_error()."<br>";
		exit;
	}
	
	function DataFormat(){
		global $Name, $Introduce, $Position, $Hours, $Menu;
		$Name = $_POST['name'];
		$Introduce = $_POST['introduce'];
		$Position01 = $_POST['PositionX'];
		$Position02 = $_POST['PositionY'];
		while (strlen($Position01) != 3){
			$Position01 = '0'.$Position01;
		}
		while (strlen($Position02) != 3){
			$Position02 = '0'.$Position02;
		}
		$Position = $Position01.$Position02;
		for ($i = 1, $Hours = ""; $i <= 7; $i++){
			for ($x = 1; $x <= 4; $x++){
				$IsTwoDigit = $_POST[$i.'Hours0'.$x];
				if (strlen($IsTwoDigit) != 2) $IsTwoDigit = '0'.$IsTwoDigit;
				$Hours .= $IsTwoDigit;
			}
			if ($i == 7) break;
			$Hours .= '@';
		}
		$iMenuNumber = $_POST['MenuNumber'];
		for ($i = 0, $Menu = ""; $i < $iMenuNumber; $i++){
			$Menu .= $_POST['Menu0'.$i].'-'.$_POST['Price0'.$i];
			if ($i == ($iMenuNumber - 1)) break;
			$Menu .= '@';
		}
	}
	
	//判斷執行哪個 Method
	$Method = $_POST['Method'];
	if ($Method == 'Insert'){
		DataFormat();

		//ID 為最小且唯一值
		$sql01 = $mysqli->query("SELECT id FROM storeinfo ORDER BY id;");
		$ID = 1;
		while ($sqlData = $sql01->fetch_object()){
			if ($ID != $sqlData->id) break;
			$ID++;
		}
		$sql01->close();
		
		$datetime = (new Datetime("now",  new DateTimeZone('Asia/Taipei')))->format("Y/m/j");
		
		if ($filename = $_FILES['userFile']['name']){
			$filename = $ID.strstr($filename, '.');
			move_uploaded_file($_FILES['userFile']['tmp_name'], "../../image/Logo/".$filename);
		}
		else $filename = '';
		
		echo "INSERT INTO storeinfo (id, name, introduce, position, hours, menu, lastModified, Logo) VALUES ($ID, '$Name', '$Introduce', '$Position', '$Hours', '$Menu', '$datetime', '$filename')";
		$mysqli->query("INSERT INTO storeinfo (id, name, introduce, position, hours, menu, lastModified, Logo) VALUES ($ID, '$Name', '$Introduce', '$Position', '$Hours', '$Menu', '$datetime', '$filename')");
		
		$account = $_SESSION['account'];
		$sql02 = $mysqli->query("SELECT storeIDs FROM storeaccount WHERE account='$account';");
		$storeIDs = explode('@', $sql02->fetch_object()->storeIDs);
		$iNumStoreIDs = count($storeIDs);
		$NewStoreIDs = '';
		//以防帳號沒有商家(ID)
		if ($storeIDs[0] == '') $NewStoreIDs = $ID;
		else {
			//ID 排序
			if ($storeIDs[0] > $ID) $NewStoreIDs .= $ID;
			else $NewStoreIDs .= $storeIDs[0];
			for ($i = 1; $i < $iNumStoreIDs; $i++){
				if (($storeIDs[$i - 1] < $ID) and ($storeIDs[$i] > $ID)) $NewStoreIDs .= '@'.$ID;
				$NewStoreIDs .= '@'.$storeIDs[$i];
			}
			if ($storeIDs[$iNumStoreIDs - 1] < $ID) $NewStoreIDs .= '@'.$ID;
		}
		$mysqli->query("UPDATE storeaccount SET storeIDs='$NewStoreIDs' WHERE account='$account'");
	}
	else if ($Method == 'Update'){
		DataFormat();

		$ID = $_POST['SelectId'];
		
		$datetime = (new Datetime("now",  new DateTimeZone('Asia/Taipei')))->format("Y/m/j");
		
		//上傳並覆蓋原本檔案
		$filename = $_FILES['userFile']['name'];
		$PreviousFilename = $mysqli->query("SELECT Logo FROM storeinfo WHERE id=$ID;")->fetch_object()->Logo;
		if ($filename != ''){
			unlink("../../image/Logo/".$PreviousFilename);
			
			$filename = $ID.strstr($filename, '.');
			move_uploaded_file($_FILES['userFile']['tmp_name'], "../../image/Logo/".$filename);
		}
		else $filename = $PreviousFilename;
		
		$mysqli->query("UPDATE storeinfo SET name='$Name', introduce='$Introduce', position='$Position', hours='$Hours', menu='$Menu', lastModified='$datetime', Logo='$filename' WHERE id='$ID';");
	}
	else if ($Method == 'Delete'){
		$ID = $_POST['SelectId'];
		
		$filename = $mysqli->query("SELECT Logo FROM storeinfo WHERE id=$ID;")->fetch_object()->Logo;
		if ($filename != '') unlink("../../image/Logo/".$filename);
		
		$mysqli->query("DELETE FROM storeinfo WHERE id=$ID;");
		
		$account = $_SESSION['account'];
		$sql01 = $mysqli->query("SELECT storeIDs FROM storeaccount WHERE account='$account';");
		$aStoreIDs = $sql01->fetch_object()->storeIDs;
		$aStoreIDs = explode('@', $aStoreIDs);
		for ($i = 0, $NewStoreIDs = ''; $i < count($aStoreIDs); $i++){
			if ($aStoreIDs[$i] == $ID) continue;
			if ($i == 0){
				$NewStoreIDs .= $aStoreIDs[$i];
				continue;
			}
			$NewStoreIDs .= '@'.$aStoreIDs[$i];
		}
		$mysqli->query("UPDATE storeaccount SET storeIDs='$NewStoreIDs' where account='$account'");
	}
	
	if ($_SESSION['user'] == 'Store') echo "<script>alert('設定完成');location.href='../SettingPage.php';</script>";
	elseif ($_SESSION['user'] == 'Manager') echo "<script>alert('設定完成');location.href='../SettingPage.php';</script>";
	
	$mysqli->close();
?>
