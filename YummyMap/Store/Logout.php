<?php
	//刪除 Session 要先讀取
	session_start();
	session_destroy();
	header('Location: http://127.0.0.1/YummyMap/Info.html');
?>
