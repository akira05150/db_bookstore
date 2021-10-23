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

//以UID查詢購物車內容
$sql_cart = "SELECT ISBN, Quantity FROM CART WHERE Uid IN ('".$uid_temp."')";
$result_cart = $db->query($sql_cart);


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

            <p class="title_text">刷下魔法小卡吧！我的購物車</p>
            <div class="divider"></div>
            
            <?php
                $index = 1;
                $initotal = 0;
                if($result_cart->rowCount()){ //購物車不為空時

                  while($row=$result_cart->fetch(PDO::FETCH_OBJ)){

                        //查詢每筆ISBN對應的資料
                        $sql_items = "SELECT Title,Price,Stock
                                      FROM BOOK
                                      WHERE ISBN IN (".$row->ISBN.")";
                        $result_item = $db->query($sql_items);
                        $r = $result_item->fetch(PDO::FETCH_OBJ);
                        $initotal += ($r->Price*$row->Quantity);
                        
                          echo "
                              
                              <div class='book'>
                                  <div class='cover' style='background-image:url(./img/cover/".$row->ISBN.".jpg);'></div>
                                  
                                  <div class='info'>
                                      <a href='http://localhost/Cart/book_detail.php?isbn=".$row->ISBN."'   class='title'>".$r->Title."</a>
                                      <p class='detail'>".$r->Price."元</p>
                                      <div class='quantity_container'>
                                          <p class='quantity_text'>數量</p>
                                          <div class='selectq'>
                                              <form id='quantityForm' method='post'>
                                                  <input id='count' name='count' type='hidden' value='".$result_cart->rowCount()."'>

                                                  <input id='detail".$index."' name='detail' type='hidden' value='".$r->Price."'>

                                                  <input id='isbn".$index."' name='isbn' type='hidden' value='".$row->ISBN."'>

                                                  <select id='Quantity".$index."' name='Quantity'
                                                    onchange='qchange(".$index.");'>";

                                                  //庫存大於10最多顯示10
                                                  if($r->Stock>=10){
                                                      for($i=1; $i<=10; $i++){
                                                        if($i==$row->Quantity){
                                                          echo "
                                                          <option value='".$i."' selected >".$i."</option>";

                                                        }
                                                        else{
                                                          echo "
                                                      　    <option value='".$i."'>".$i."</option>";

                                                        }
                                                    }
                                                  }
                                                  else{
                                                    for($i=1; $i<=$r->Stock; $i++){
                                                      if($i==$row->Quantity){
                                                          echo "
                                                          <option value='".$i."' selected >".$i."</option>";

                                                      }
                                                      else{
                                                        echo "
                                                    　    <option value='".$i."'>".$i."</option>";
                                                      }
                                                    }
                                                  }
                                                  echo "
                                                  </select>
                                              </form>
                                          </div>
                                      </div>
                                      <p class='price' id='price".$index."'>共".($row->Quantity*$r->Price)."元</p>
                                  </div>
          
                                  <div class='delete_container'>
                                    <form action='cart_delete.php' method='post' >
                                      <input id='isbn".$index."' name='isbn' type='hidden' value='".$row->ISBN."'>
                                      <input type='Submit' class='delete' value=''>
                                    </form>
                                  </div>
                                  
                              </div>
                              <div class='divider_long'></div>
                          ";
                          $index++; //給予不一樣的id，以便js抓取id內容
                        }
                        
                }
            ?>
            <!-- <div id="results">
              查看內容
            </div> -->
            <form action="buy.php" method="post">
              <!-- 收件人資訊 -->
              <div class="receiver">
                  <p class="title_text">收件人資訊</p>
                  <div class="divider" style="margin-bottom:5.5vh;"></div>
                  
                    <label for="rname" class="hint">收件人姓名</label>
                    <input type="text" class="text_area" name="rname">
                    <label for="phone" class="hint">手機/電話</label>
                    <input type="text" class="text_area" name="phone">
                    <label for="address" class="hint">地址</label>
                    <input type="text" class="text_area" style='width: 52vw;' name="address">
                
              </div>

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

                  <!-- 購買鍵 -->
                  <input type='submit' class='add_book' style="float:right;" value="購買" >
              </div>
            </form>
   
        </div>

    </div>

  </div>

</body>
</html>
