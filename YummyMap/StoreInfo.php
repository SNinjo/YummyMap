<head>
	<title>YummyMap</title>
	<link rel="stylesheet" type="text/css" href="Map.css">
</head>

<body id="InfoBody">
	<section class="InfoBK">
		<img id="InfoBack" src="image/InfoBack.png" onclick="history.back()">
		<?php 
			$mysqli = new mysqli('localhost', 'Client', '', 'yummymap');
			if (mysqli_connect_error()){
				echo "連結錯誤訊息: ".mysqli_connect_error()."<br>";
				exit;
			}
			
			$ID = $_POST['SelectLM'];
			$sql01 = $mysqli->query("SELECT * FROM storeinfo WHERE id=$ID;");
			$Row01 = $sql01->num_rows;
			if ($Row01 == ""){
				echo "<h2>查無資料</h2> <br>";
				exit;
			}
			
			$sqlData = $sql01->fetch_object();
			echo "<h2>".$sqlData->name ."</h2>";
			echo "<p>".$sqlData->introduce ."</h2>";
			
			//排版暫時
			echo "<p></p>";
			
			$aHours = explode('@', $sqlData->hours);
			$aWeek = array("星期一", "星期二", "星期三", "星期四", "星期五", "星期六", "星期日");
			echo "<table id='HoursTable' border='1' width='200' align='center'>";
			for ($i = 0; $i < 7; $i++){
				if($aHours[$i] == '-1'){
					echo "<tr><td align='center'>".$aWeek[$i]."</td><td align='center'>公休</td></tr>";
					continue;
				}
				echo "<tr><td align='center'>".$aWeek[$i]."</td><td align='center'>".substr($aHours[$i], 0,2).":".substr($aHours[$i], 2,2)." ~ ".substr($aHours[$i], 4,2).":".substr($aHours[$i], 6,2)."</td></tr>";
			}
			echo "</table>";
			
			$aMenu = explode('@', $sqlData->menu);
			echo "<table id='MenuTable' border='1' width='200' align='center'>";
			foreach ($aMenu as $cDish){
				if ($cDish == '') {
					echo "<tr><td align='center'> null </td>";
					return;
				}
				$aDish = explode('-', $cDish);
				echo "<tr><td align='center'>".$aDish[0]."</td><td align='center'>".$aDish[1]."</td></tr>";
			}
			echo "</table>";
			
			$sql01->close();
		$mysqli->close();
		?>
	</section>
	
	<aside>
		<input type="button" onclick="javascript:location.href='Home.html'" class="Button" style="background-image:url(image/Button_Home.png);">
		<input type="button" onclick="javascript:location.href='Map.html'" class="Button" style="background-image:url(image/Button_Map.png);">
		<input type="button" onclick="javascript:location.href='Info.html'" class="Button" style="background-image:url(image/Button_Info.png);">
		<input type="button" onclick="javascript:location.href='Version.html'" class="Button" style="background-image:url(image/Button_Version.png);">
	</aside>
</body>
