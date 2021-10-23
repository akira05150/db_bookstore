<?php

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

// Update quantity資訊
$sql_updateq = "UPDATE CART SET Quantity='".$quantity."' WHERE ISBN='".$isbn."' AND Uid='".$uid_temp."';";
$result_updateq = $db->query($sql_updateq);

?>

