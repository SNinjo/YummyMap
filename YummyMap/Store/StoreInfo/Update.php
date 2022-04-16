<head>
	<title>YummyMap</title>
	<style>
		#SelectPosition {
			width: 50%;
			height: 50%;
			background-image:url("../../image/MapBK.png");
			background-size:100% 100%;
			background-repeat:no-repeat;
		}
		.LM{
			width: 4%;
			height: 8%;
		}
	</style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
	<script>
		$(document).ready(function() {iMenuNum = ($('#MenuNumber').val() - 1);})
		function MenuPlus(){
			if (iMenuNum == 9) return;
			iMenuNum++;
			$("#MenuNumber").val(iMenuNum + 1);
			$("#MenuInput").append("<input type='text' id='Menu0" + iMenuNum + "' name='Menu0" + iMenuNum + "' required><input type='number' id='Price0" + iMenuNum + "' name='Price0" + iMenuNum + "' value='0' max='999' min='0'><br id='Break0" + iMenuNum + "'>");
		}
		function MenuMinus(){
			if (iMenuNum == 0) return;
			$("#Menu0" + iMenuNum).remove();
			$("#Price0" + iMenuNum).remove();
			$("#Break0" + iMenuNum).remove();
			iMenuNum--;
			$("#MenuNumber").val(iMenuNum + 1);
		}
		
		//注意圖片載入問題(載入有時間差，使用 onload)
		function PreviewLogo(Input){
			//Change 不代表有檔案
			if (Input.files && Input.files[0]) {
				var regExp = /(gif|png|jpg|jpeg)$/;
				if (!regExp.test(Input.files[0].type)){
					alert("檔案格式錯誤: 只接受 GIF/ PNG/ JPG/ JPEG");
					$('#Form').trigger("reset");
					$('#LM').attr('src', "../image/Landmark.png");
				}
				else {
					var reader = new FileReader();
					reader.onload = function(e) {
						$('#LM').attr('src', e.target.result);
					}
					reader.readAsDataURL(Input.files[0]); // convert to base64 string
				}
			}
		}
		function CheckSize(){
			var Img = document.getElementById("LM");
			if ((Img.naturalWidth != 256) || (Img.naturalHeight != 256)){
				alert("大小格式錯誤: 只接受 256 * 256");
				$('#Form').trigger("reset");
				$('#LM').attr('src', "../image/Landmark.png");
			}
		}
		
		//圖片點選商家位置
		$(document).ready(function(){
			var X = $("#PositionX").val(), Y = $("#PositionY").val();
			
			const element = document.getElementById('SelectPosition');
			element.addEventListener('click', function(e) {
				X = (e.offsetX / element.clientWidth * 100).toFixed(0) - 2;
				Y = (e.offsetY / element.clientHeight * 100).toFixed(0) - 8;
				if (X < 0) X = 0;
				if (Y < 0) Y = 0;
				$("#PositionX").val(X);
				$("#PositionY").val(Y);
				$("#ClickSite").css({"left": X + "%", "top": Y + "%"});
			})
			
			//Click 商標(子物件)處理
			const elementChild = document.getElementById('ClickSite');
			elementChild.addEventListener('click', function(e) {
				event.stopPropagation();
				
				X = parseInt(X) + parseInt((e.offsetX / element.clientWidth * 100).toFixed(0)) - 2;
				Y = parseInt(Y) + parseInt((e.offsetY / element.clientHeight * 100).toFixed(0)) - 8;
				if (X < 0) X = 0;
				if (Y < 0) Y = 0;
				$("#PositionX").val(X);
				$("#PositionY").val(Y);
				$("#ClickSite").css({"left": X + "%", "top": Y + "%"});
			})
		})
	</script>
</head>
<body>
	<form action="./InputData.php" method="post" enctype='multipart/form-data'>
		<h1> 更改商家資料:  <input type="submit" value="確定送出"><input type="hidden" name="Method" value="Update"></h1>
		<?php 
			$mysqli = new mysqli('localhost', 'Store', 'StoreSelf', 'yummymap');
			if (mysqli_connect_error()){
				echo "連結錯誤訊息: ".mysqli_connect_error()."<br>";
				exit;
			}
			
			$ID = $_GET['SelectId'];
			$sql01 = $mysqli->query("SELECT * FROM storeinfo WHERE id=$ID;");
			$Row01 = $sql01->num_rows;
			if ($Row01 == ""){
				echo "<h2>查無資料</h2> <br>";
				exit;
			}
			
			$sqlData = $sql01->fetch_object();
			echo '<p>ID: <input type="number" name="SelectId" value="'.$ID.'" readonly><br>';
			echo '<p>店名:<input type="text" name="name" value="'.$sqlData->name .'" required></p>';
			$Logo = $sqlData->Logo;
			echo '<p>Logo(格式: 256*256 GIF/ PNG/ JPG): <input type="file" id="userFile" name="userFile" onchange="PreviewLogo(this)" accept="image/gif, image/jpeg, image/png"><img id="LM" class="LM" onload="CheckSize()" src="'.(($Logo == '')? ("../../image/Landmark.png"):("../../image/Logo/".$Logo)).'"></p>';
			echo '<p>商家介紹: <textarea name="introduce" maxlength="100" cols="50" rows="5" required>'.$sqlData->introduce .'</textarea></p>';
			$X = intval($sqlData->position / 1000);
			$Y = $sqlData->position % 1000;
			echo $X.' '.$Y.'<br>';
			echo '<p>地圖位置 X軸:<input type="number" id="PositionX" name="PositionX" value="'.$X.'" max="100" min="0"> Y軸:<input type="number" id="PositionY" name="PositionY" value="'.$Y.'" max="100" min="0"></p><p>~可點選圖片選取位置~<section id="SelectPosition"><img id="ClickSite" class="LM" style="position: relative;left: '.$X.'%;top: '.$Y.'%;" src="../../image/Landmark_red.png"></section></p>';
			$aHours = explode('@', $sqlData->hours);
			$aWeek = array("星期一", "星期二", "星期三", "星期四", "星期五", "星期六", "星期日");
			for ($i = 0; $i < 7; $i++){
				$iTem = $i + 1;
				echo '<p>'.$aWeek[$i].'<input type="Number" name="'.$iTem.'Hours01" value="'.substr($aHours[$i], 0,2).'" max="23" min="0">:<input type="Number" name="'.$iTem.'Hours02" value="'.substr($aHours[$i], 2,2).'" max="59" min="0"> ~ <input type="Number" name="'.$iTem.'Hours03" value="'.substr($aHours[$i], 4,2).'" max="23" min="0">:<input type="Number" name="'.$iTem.'Hours04" value="'.substr($aHours[$i], 6,2).'" max="59" min="0"></p>';
			}
			$aMenu = explode('@', $sqlData->menu);
			$iMenuNumber = count($aMenu);
			echo '<p>菜單 數量:<input type="number" id="MenuNumber" name="MenuNumber" value="'.$iMenuNumber.'" readonly><input type="button" id="MenuPlusButton" value="++" onclick="MenuPlus()"><input type="button" id="MenuMinusButton" value="--" onclick="MenuMinus()"></p><section id="MenuInput">';
			for ($i = 0; $i < $iMenuNumber; $i++){
				$aDish = explode('-', $aMenu[$i]);
				if ($aMenu[$i] == '') $aDish = array('', '');
				echo '<input type="text" id="Menu0'.$i.'" name="Menu0'.$i.'" value="'.$aDish[0].'" required><input type="number" id="Price0'.$i.'" name="Price0'.$i.'" value="'.$aDish[1].'" max="999" min="0"><br id="Break0'.$i.'">';
			}
			echo '</section>';
			echo '<p>最後修改時間: <input type="text" name="lastModified" value="'.$sqlData->lastModified .'" readonly></p>';
			
			$sql01->close();
			$mysqli->close();
		?>
	</form>
</body>
