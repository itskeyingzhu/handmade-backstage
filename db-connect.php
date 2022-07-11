<?php  
$serverName = "localhost";
$username = "admin";
$password = "12345";
$dbname = "hand_db";

try{
    $con=mysqli_connect($serverName ,
    $username,
    $password,
    $dbname);
    $db_host=new PDO("mysql:host={$serverName};dbname={$dbname};charset=utf8",$username,$password);
    $db_host->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //讓資料庫顯示錯誤原因
}catch(PDOException $e){
    echo "資料庫連線失敗";
    echo "Error: ".$e->getMessage();
    exit;
}

?>


