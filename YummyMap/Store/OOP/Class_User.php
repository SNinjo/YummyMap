<?php
    class User{
        public $account;
        public $storeIDs;
        public $banned;
        public $lastLogin;
        
        function __construct(){
            $mysqli = new mysqli('localhost', 'Store', 'StoreSelf', 'yummymap');
            if (mysqli_connect_error()){
                echo "連結錯誤訊息: ".mysqli_connect_error()."<br>";
                exit;
            }

            $this->account = $_SESSION['account'];
            $aStoreData = $mysqli->query("SELECT * FROM storeaccount WHERE account='$this->account';")->fetch_object();
            $storeIDs = $aStoreData->storeIDs;
            $this->storeIDs = explode('@', $storeIDs);
            $this->banned = $aStoreData->banned;
            $this->lastLogin = $aStoreData->lastLogin;

            $mysqli->close();
        }

        function Show($mysqli){
            echo "<h2>$this->account 的設定頁面 <input type='button' value='帳戶設定' onclick=\"javascript:location.href='http://127.0.0.1/MyWebsite/YummyMap/Store/SetAccount.php'\"'><input type='button' value='登出' onclick=\"javascript:location.href='http://127.0.0.1/MyWebsite/YummyMap/Store/Logout.php'\"'></h2>";
            
            echo "<table width='400'><tr><td>ID</td><td align='center'>name</td><td>Method</td><td>Last Modified</td></tr>";
            //判斷: 1.以防帳號沒有商家(ID)  2.登入者為管理員要轉址
            if ($this->storeIDs == ''){
                echo "<tr><td></td><td align='center'>暫無資料</td><td></td><td></td></tr></table>";
            }
            elseif ($this->storeIDs[0] == '0'){
                $_SESSION['user'] = 'Manager';
                header('Location: http://127.0.0.1/MyWebsite/YummyMap/Manager/ManagerPage.php');
                exit;
            }
            else {
                foreach ($this->storeIDs as $ID){
                    $sql = $mysqli->query("SELECT id, name, lastModified FROM storeinfo WHERE id=$ID;");
                    $sqlData = $sql->fetch_object();
                    echo "<tr><td>".$ID."</td><td align='center'>".$sqlData->name ."</td><td><a href='Update.php?SelectId=".$ID."'> 編輯 </a><a href='Delete.php?SelectId=".$ID."'> 刪除 </a></td><td>".$sqlData->lastModified ."</td></tr>";
                    $sql->close();
                }
                echo "</table>";
            }
            
            echo "<p><a href='Insert.html'>新增...</a></p>";
        }

        function Login($mysqli, $account, $password){
            //判斷是否登入 (Session 儲存登入帳號)
            if (isset($_POST['account'])){
                $account = $_POST['account'];
                $password = $_POST['password'];
                
                //驗證帳密
                $sql01 = $mysqli->query("SELECT storeIDs, banned, password FROM storeaccount WHERE account='$account';");
                $sqlData = $sql01->fetch_object();
                if ($sql01->num_rows == ''){
                    echo "<script>alert('帳號不存在');location.href='http://127.0.0.1/MyWebsite/YummyMap/Info.html';</script>";
                    exit;
                }
                elseif ($sqlData->banned){
                    //確認使否封鎖
                    echo "<script>alert('此帳號已被封鎖');location.href='http://127.0.0.1/MyWebsite/YummyMap/Info.html';</script>";
                    exit;
                }
                elseif (!password_verify($password, '$2y$11$'.($sqlData->password))){
                    echo "<script>alert('密碼錯誤');location.href='http://127.0.0.1/MyWebsite/YummyMap/Info.html';</script>";
                    exit;
                }
                else {
                    $_SESSION['account'] = $account;
                    $_SESSION['user'] = 'Store';
                }
                
                $sql01->close();
            }
            else $account = $_SESSION['account'];

            Construct($mysqli);
        }
    }
?>
