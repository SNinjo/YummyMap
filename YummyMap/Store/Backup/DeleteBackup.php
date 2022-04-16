<?php 
    $file = $_GET['SelectFile'];
	if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN'){
		exec('start Backup.bat Delete Manual_'.$file, $output, $Error);
	}
	else {
		echo '<script>alert("目前只支援 Windows系統");document.location.href="./ManagerPage.php";</script>';
        exit;
    }
    
    if ($Error) alert('發生錯誤');
    else{
        $file = $_GET['SelectFile'];
        $mysqli = new mysqli('localhost', 'Manager', 'MapManager0556', 'Backup');
        if (mysqli_connect_error()){
            echo "連結錯誤訊息: ".mysqli_connect_error()."<br>";
            exit;
        }
    
        $mysqli->query("DELETE FROM yummymap WHERE file = '$file';");
    }
	
	header('Location: ../ManagerPage.php');
?>
