<?php

$uid_temp = $_COOKIE["uid_temp"];
$rname =  $_POST["rname"];
$phone = $_POST["phone"];
$address = $_POST["address"];

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

$onum = uniqid($more_entropy = true);

// 將資料加入ORDER_info
$date = date('Y-m-d');
$sql_add_info = "INSERT INTO ORDER_INFO (Onum, Uid, Receiver, Phone, Address, Odate)
                    VALUES ('".$onum."', '".$uid_temp."', '".$rname."', '".$phone."', '".$address."', '".$date."');";

echo $sql_add_info;
$result_info = $db->query($sql_add_info);


// 查詢uid內所有購買資訊
$sql_orderlist = "SELECT * FROM CART WHERE Uid = '".$uid_temp."'";
$result_ol = $db->query($sql_orderlist);

echo $onum."<br>";
// 將資料加入ORDERS
while($row=$result_ol->fetch(PDO::FETCH_OBJ)){

    //找到書價格
    $sql_subtotal = "SELECT Price FROM BOOK WHERE ISBN='".$row->ISBN."'";
    $result_subtotal = $db->query($sql_subtotal);
    $book = $result_subtotal->fetch(PDO::FETCH_OBJ);

    // 存入ORDERS
    $sql_insert_order = "INSERT INTO ORDERS (Onum, ISBN, Uid, Quantity, Subtotal)
                    VALUES ('".$onum."', '".$row->ISBN."', '".$row->Uid."', ".$row->Quantity.", ".($book->Price*$row->Quantity).");";
    echo $sql_insert_order."<br>";          
    $db->query($sql_insert_order);
}

// 刪除對應CART內容
$sql_delete_cart = "DELETE FROM CART WHERE Uid='".$uid_temp."';";
$result_delete_cart = $db->query($sql_delete_cart);


// 將Onum傳出去
// session_start();
// $_SESSION['onum'] = $onum;


//重定向瀏覽器
Header("Location:show_order.php");

?>
