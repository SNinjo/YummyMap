<head>
	<title>YummyMap</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
	<script>
		function ShowIDs(){
			$('#managerOption').empty();
			$('#managerOption').append("<option> Manager </option>");
			var aStoreIDs = ($('#managerIDs').val()).split('@');
			for (var x in aStoreIDs){
				x = aStoreIDs[x];
				if (x == '0') continue;
				showX = x;
				while (showX.length != 3) showX = '0' + showX;
				$('#managerOption').append("<option value='" + x + "'>" + showX + "</option>");
			}
			
			$('#storeOption').empty();
			$('#storeOption').append("<option> @ Store </option>");
			var aStoreIDs = ($('#storeIDs').val()).split('@');
			for (var x in aStoreIDs){
				x = aStoreIDs[x];
				if (x == '0') continue;
				showX = x;
				while (showX.length != 3) showX = '0' + showX;
				$('#storeOption').append("<option value='" + x + "'>" + showX + "</option>");
			}
		}
		
		function Manager2Store(){
			var managerIDs = ($('#managerIDs').val()).split('@');
			var storeIDs = ($('#storeIDs').val()).split('@');
			var aSelectIDs = $('#managerOption').val();

			//不能選擇 Manager
			if (aSelectIDs == "Manager") return
			for (var x in aSelectIDs){
				x = aSelectIDs[x];
				storeIDs.push(x);
				managerIDs.splice(managerIDs.indexOf(x), 1);
			}
			storeIDs.sort();
			
			$('#managerIDs').val(managerIDs.join('@'));
			$('#storeIDs').val(storeIDs.join('@'));
			ShowIDs();
		}
		function Store2Manager(){
			var managerIDs = ($('#managerIDs').val()).split('@');
			var storeIDs = ($('#storeIDs').val()).split('@');
			var aSelectIDs = $('#storeOption').val();

			//不能選擇 @ Store
			if (aSelectIDs == "@ Store") return
			for (var x in aSelectIDs){
				x = aSelectIDs[x];
				managerIDs.push(x);
				storeIDs.splice(storeIDs.indexOf(x), 1);
			}
			managerIDs.sort();
			
			$('#managerIDs').val(managerIDs.join('@'));
			$('#storeIDs').val(storeIDs.join('@'));
			ShowIDs();
		}
		
		function Submit(){
			$('#storeIDs').val(($('#storeIDs').val()).substring (2));
			$('#EditForm').submit();
		}
	</script>
</head>
<body>
	<?php session_start();
		$mysqli = new mysqli('localhost', 'Manager', 'MapManager0556', 'yummymap');
		if (mysqli_connect_error()){
			echo "連結錯誤訊息: ".mysqli_connect_error()."<br>";
			exit;
		}
		
		$account = $_GET['SelectAccount'];
		echo '<form id="EditForm" action="./InputData.php?SelectAccount='.$account.'&Method=Edit" method="post"><h1> 編輯商家資料:  <input type="button" value="確定送出" onclick="Submit()"></h1>';
		
		$ManagerAccount = $_SESSION['account'];
		$storeIDs = $mysqli->query("SELECT storeIDs FROM storeaccount WHERE account='$account'")->fetch_object()->storeIDs;
		//商家 ID列表前面加 0，避免空陣列的存取錯誤
		if ($storeIDs == '') $storeIDs = '0';
		else $storeIDs = '0@'.$storeIDs;
		$managerIDs = $mysqli->query("SELECT storeIDs FROM storeaccount WHERE account='$ManagerAccount'")->fetch_object()->storeIDs;
		echo "<input type='hidden' name='managerIDs' id='managerIDs' value='$managerIDs'><input type='hidden' name='storeIDs' id='storeIDs' value='$storeIDs'></form>";
	?>
	<select id="managerOption" multiple="multiple" width="300">
		<option> Manager </option>
	</select>
	<input type="button" value="<-" onclick="Store2Manager()"><input type="button" value="->" onclick="Manager2Store()">
	<select id="storeOption" multiple="multiple" width="300">
		<option>@ Store </option>
	</select>
	<script> ShowIDs(); </script><!--網頁讀取好顯示 ID列表-->
</body>
