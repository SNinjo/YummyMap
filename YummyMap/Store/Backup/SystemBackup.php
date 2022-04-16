<?php 
	if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN'){
		exec('start Backup.bat SystemStore', $output, $Error);
	}
	else {
		echo '<script>alert("目前只支援 Windows系統");document.location.href="../ManagerPage.php";</script>';
        exit;
	}
	if ($Error) alert('發生錯誤');
	else {
		$mysqli = new mysqli('localhost', 'Manager', 'MapManager0556', 'Backup');
		if (mysqli_connect_error()){
			echo "連結錯誤訊息: ".mysqli_connect_error()."<br>";
			exit;
		}

		$datetime = (new Datetime("now",  new DateTimeZone('Asia/Taipei')))->format("Y.m.d");
		$mysqli->query("INSERT INTO yummymap (file, form) VALUES ('$datetime', 'System');");

		//系統最多儲存 10個系統備份
		$sql01 = $mysqli->query("SELECT file FROM yummymap WHERE form='System' ORDER BY file");
		if ($sql01->num_rows > 10){
			$target = $sql01->fetch_object()->file;
			$mysqli->query("DELETE FROM yummymap WHERE file='$target'");

			if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN'){
				exec('start DeleteBackup.bat '.$target, $output, $Error);
			}
			else {
				echo '<script>alert("目前只支援 Windows系統");document.location.href="../ManagerPage.php";</script>';
        		exit;
			}
		}
	}
	
	header('Location: ../ManagerPage.php');
?>
