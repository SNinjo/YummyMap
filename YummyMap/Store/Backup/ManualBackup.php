<?php
    if ($_GET['SelectFile'] == '__Nobody__'){
        $mysqli = new mysqli('localhost', 'Manager', 'MapManager0556', 'Backup');
        if (mysqli_connect_error()){
            echo "連結錯誤訊息: ".mysqli_connect_error()."<br>";
            exit;
        }
    
        $sql01 = $mysqli->query("SELECT file FROM yummymap WHERE (file REGEXP 'Backup[0-9]') AND (form = 'Manual') ORDER BY file;");
        if ($sql01->num_rows == ''){
            $iNumber = 1;
        }
        else {
            $iNumber = 1;
            while ($sqlData = $sql01->fetch_object()){
                $OtherNum = substr($sqlData->file, 6);
                if ($iNumber != $OtherNum) break;
			    $iNumber++;
            }
        }
        $file = 'Backup'.$iNumber;
        $mysqli->query("INSERT INTO yummymap (file, form) VALUES ('$file', 'Manual');");
    }
    else $file = $_GET['SelectFile'];

	if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN'){
		exec('start Backup.bat ManualStore Manual_'.$file, $output, $Error);
	}
	else {
		echo '<script>alert("目前只支援 Windows系統");document.location.href="../ManagerPage.php";</script>';
        exit;
	}
	if ($Error) alert('發生錯誤');
	
	header('Location: ../ManagerPage.php');
?>
