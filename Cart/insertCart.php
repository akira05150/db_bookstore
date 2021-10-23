<?php
    echo $_COOKIE["uid_temp"]."<br />";
    echo $_POST['isbn'] ."<br />";
    echo $_POST['quantity'] ."<br />";
    echo "==============================<br />";
    echo "已成功將資料POST過來，且不用刷新頁面！";

$uid_temp = $_COOKIE["uid_temp"];
$isbn = $_POST['isbn'];
$quantity = $_POST['quantity'];

$db_type = "mysql";
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "bookstoredb";
try {
  $db = new PDO($db_type . ':host=' . $db_host . ';dbname=' . $db_name, $db_user, $db_password);

  $db->query('SET NAMES UTF8');
  } 
  catch (PDOException $e) {
  echo 'Error!: ' . $e->getMessage();
}

//檢查uid是否存在USER內
$sql_uid = "SELECT Uid FROM USER WHERE Uid IN ('".$uid_temp."');";
$result_uid = $db->query($sql_uid);

if($result_uid->rowCount()==0){ //未存在uid於user中， 建立user資料
    $sql_add_user = "INSERT INTO USER (Uid) VALUES ('".$uid_temp."');";
    $result_insert_user = $db->query($sql_add_user);
    echo "insert to user<br>";
}


//檢查購物車是否已有欲新增的內容
$sql_cart = "SELECT * FROM CART WHERE Uid IN ('".$uid_temp."') AND ISBN IN ('".$isbn."');";
$result_cart = $db->query($sql_cart);

if($result_cart->rowCount()==0){ //不在購物車內就新增
    $sql_add_cart = "INSERT INTO CART (ISBN, Uid, Quantity) VALUES ('".$isbn."', '".$uid_temp."', 1);";
    $result_insert_cart = $db->query($sql_add_cart);
    echo "insert to cart<br>";

} else{
    //已在購物車內，不做事
    echo "Nothing";
}
?>
