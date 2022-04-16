<head>
	<title> YummyMap </title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
	<script>
		$(document).ready(function(){
			if (confirm("確定刪除嗎? (刪除後資料將無法復原)")){
				document.getElementById('form').submit();
			}
			else{
				document.location.href="../SettingPage.php";
			}
		})
	</script>
</head>
<body>
	<form id="form" action="./InputData.php" method="post">
		<input type="hidden" name="Method" value="Delete">
		<input type="text" name="SelectId" value="<?php echo $_GET['SelectId']; ?>">
	</form>
</body>
