<?php 
	$file = $_GET['SelectFile'];
	exec('start Backup.bat Change '.$file, $output, $Error);
	
	if ($Error) alert('發生錯誤');
	
	header('Location: ../ManagerPage.php');
?>
