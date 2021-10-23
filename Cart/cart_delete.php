<?php


echo $_COOKIE["uid_temp"]."<br />";
echo $_POST['isbn'] ."<br />";

$uid_temp = $_COOKIE["uid_temp"];
$isbn = $_POST['isbn'];

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

// 刪除品項
$sql_delete = "DELETE FROM CART WHERE  ISBN='".$isbn."' AND Uid='".$uid_temp."';";
$result_delete = $db->query($sql_delete);

//重定向瀏覽器
header("Location:cart.php");

?>
