<head>
	<title>YummyMap</title>
	<link rel="stylesheet" type="text/css" href="Map.css">
	<script src="./jquery-3.4.1.min.js"></script>
	<script>
		function LMSubmit(LM){
			var ID = LM.id.slice(1,4);
			$("#WhichLM").val(ID);
			$("#FormLandmark").submit();
			}
	</script>
</head>

<body id="InfoBody">
	<section id="Map">
		<?php
			//以 PHP 讀取地標位置
			$mysqli = new mysqli('localhost', 'Client', '', 'yummymap');
			if (mysqli_connect_error()){
				echo "連結錯誤訊息: ".mysqli_connect_error()."<br>";
				exit;
			}
				
			$sql01 = $mysqli->query("SELECT id, position, Logo FROM storeinfo;");
			$Row01 = $sql01->num_rows;
			if ($Row01 == ""){
				echo "<h2>查無資料</h2> <br>";
				exit;
			}
			
			while ($sqlData = $sql01->fetch_object()){
				$x = intval($sqlData->position / 1000);
				$y = $sqlData->position % 1000;
				$Logo = $sqlData->Logo;
				echo "<img id='S$sqlData->id' class='LM' style='position: absolute;left: $x%;top: $y%;' src='".(($Logo == '')? ("image/Landmark.png"):("image/Logo/".$Logo))."' onclick='LMSubmit(this)'>";
			}
		?>
	</section>
	
	<section id="white"></section>
	<form action="./StoreInfo.php" id="FormLandmark" method="post">
		<input type="text" id="WhichLM" name="SelectLM">
	</form>
	
	<aside>
		<input type="button" onclick="javascript:location.href='Home.html'" class="Button" style="background-image:url(image/Button_Home.png);">
		<input type="button" onclick="javascript:location.href='Map.html'" class="Button" style="background-image:url(image/Button_Map.png);">
		<input type="button" onclick="javascript:location.href='Info.html'" class="Button" style="background-image:url(image/Button_Info.png);">
		<input type="button" onclick="javascript:location.href='Version.html'" class="Button" style="background-image:url(image/Button_Version.png);">
	</aside>
</body>