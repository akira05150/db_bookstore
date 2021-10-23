<?php

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

$uid_temp = $_COOKIE["uid_temp"];
// $onum = $_SESSION['onum'];

//以UID查詢購物車內容
$sql_olist = "SELECT * FROM ORDERS WHERE Uid IN ('".$uid_temp."') ORDER BY Onum ASC";
$result_olist = $db->query($sql_olist);

?>


<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="./css/styles_cart.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto Sans TC">

  <script src="http://code.jquery.com/jquery-latest.js"></script>
  <script type="text/javascript" src="add_toCart.js"></script>
 
</head>

<body>

  <div class="bar">
    <a class="home" href="index.php">HOME</a>
    <form action='search.php' method='GET' class = "f">
      <input type=text name="search" class="search" >
      <input type="submit" Value = "" class="search_icon">
    </form>
    <!-- 進入購物車 -->
    <input type="button" class="goCart_icon">
    <!-- 登入鍵 -->
    <input type="button" class="login" Value="Log in">
  </div>

  <div class="col">
    <div class="content">
        <!-- 橫向排版 -->
        <div class="nav_bar">
        <!-- 分類頁 -->
        </div>

        <!-- 書本內容 -->
        <div class="book_content">

            <p class="title_text">我的吃土單</p>
            <div class="divider"></div>
            
            <?php
                $initotal = 0;
                if($result_olist->rowCount()){ //購物清單不為空時

                  while($row=$result_olist->fetch(PDO::FETCH_OBJ)){

                        //查詢每筆ISBN對應的書資訊
                        $sql_items = "SELECT Title,Price,Stock
                                      FROM BOOK
                                      WHERE ISBN IN (".$row->ISBN.")";
                        $result_item = $db->query($sql_items);
                        $r = $result_item->fetch(PDO::FETCH_OBJ);

                        $initotal += $row->Subtotal;
                        
                          echo " 
                              <div class='book'>
                                  <div class='cover' style='background-image:url(./img/cover/".$row->ISBN.".jpg);'></div>
                                  
                                  <div class='info'>
                                      <p class='detail'>訂單編號：".$row->Onum."</p>
                                      <a href='http://localhost/Cart/book_detail.php?isbn=".$row->ISBN."'  class='title'>".$r->Title."</a>
                                      <p class='detail'>".$r->Price."元</p>
                                      <div class='quantity_container'>
                                          <p class='quantity_text'>數量： </p>
                                          <p class='quantity_text'>".$result_olist->rowCount()."</p>
                                      </div>
                                      <p class='price' id='price'>共".$row->Subtotal."元</p>
                                    </div>               
                              </div>
                              <div class='divider_long'></div>
                          ";
                          
                        }
                        
                }
            ?>

            <div class='divider_long'></div>

              <!-- 下訂結帳 -->
              <div class="total">
                  <div>
                      <p class="title_text" style="text-align:right;">總計</p>
                  </div>
                  <div style="display: flex; justify-content: flex-end;">
                      <div class="divider" style="width:15.6vw"></div>
                  </div>
                  <div style="text-align:right;">
                      <p id='total' class='detail' style="margin-top:3.15vh; font-size:25px"><?php echo $initotal."元";?></p>
                  </div>

                </div>

   
        </div>

    </div>

  </div>

</body>
</html>
