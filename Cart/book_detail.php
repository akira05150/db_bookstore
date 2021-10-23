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

//用GET傳欲找的書
$isbn_book = $_GET['isbn'];

//書資訊
$sql = "SELECT ISBN,Title,Price,Publisher,Pdate,Stock,Intro
        FROM book
        WHERE ".$isbn_book." = ISBN";
$result = $db->query($sql);
//作者資訊
$sql_author = "SELECT Aname,Aintro
               FROM AUTHOR
               WHERE Aid IN (SELECT Aid FROM WRITTEN WHERE ISBN = ".$isbn_book.")";
$author_info = $db->query($sql_author);


// while($row=$result->fetch(PDO::FETCH_OBJ)){   
//         //PDO::FETCH_OBJ 指定取出資料的型態
//         echo "ISBN".$row->ISBN."<br>"; //for cover
//         echo "Title".$row->Title."<br>"; // 書名
//         echo "Price".$row->Price."<br>"; // 價錢
//         echo "Publisher".$row->Publisher."<br>";
//         echo "Pdate".$row->Pdate."<br>";
//         echo "Stock".$row->Stock."<br>"; 
//         echo "Intro".$row->Intro."<br>";
//     }

// while($row=$author_info->fetch(PDO::FETCH_OBJ)){   
//         //PDO::FETCH_OBJ 指定取出資料的型態
//         echo "Aname".$row->Aname."<br>"; // 作者名
//         echo "Aintro".$row->Aintro."<br>"; // 作者簡介
//     }

?>


<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="./css/styles_book.css">
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
    <a class="goCart_icon" href="cart.php"></a>
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
            <div class="book">
              <!-- <div id="results">

              </div> -->
              <?php
                  while($row=$result->fetch(PDO::FETCH_OBJ) ){
                    $author=$author_info->fetch(PDO::FETCH_OBJ);
                    echo "
                          <div class='cover' style='background-image:url(./img/cover/".$isbn_book.".jpg);'>
                          </div>
                          <div class='info'>
                              <p class='title'>".$row->Title."</p>
                              <p class='price'>".$row->Price."元</p>
                              <p class='detail'>作者：".$author->Aname."</p>
                              <p class='detail'>出版社：".$row->Publisher."</p>
                              <p class='detail'>出版日期：".$row->Pdate."</p>
                              <form id='cartForm' method='post' style='display:inline-block'>
                                <input id='isbn' name='isbn' type='hidden' value='".$isbn_book."'>
                                <input id='quantity' name='quantity' type='hidden' value='1'>
                                <input type='button' class='add_book' onclick='add_toCart();' value='加入購物車' />
                              </form>
                              <p class='stock'>參考庫存<=".$row->Stock."</p>
                          </div>
                      </div>
                      <div class='article'>
                          <p class='content_title'>內容簡介</p>
                          <div class='divider2'></div>
                          <p class='content_article'>".nl2br($row->Intro)."</p>
                          <p class='content_title'>作者簡介</p>
                          <div class='divider2'></div>
                          <p class='content_article' style='font-weight:bold;'>".nl2br($author->Aname)."</p>
                          <p class='content_article'>".nl2br($author->Aintro)."</p>
                      </div>
                    ";
                  }   
              ?>


            <!-- <div class='cover' style='background-image:url(./img/cover/9789573334729.jpg);'>
              </div>
              <div class='info'>
                  <p class='title'>寂寞的頻率</p>
                  <p class='price'>300元</p>
                  <p class='detail'>作者：乙一</p>
                  <p class='detail'>出版社：皇冠文化</p>
                  <p class='detail'>出版日期：2019/6/2</p>
                  <button class='add_book'>加入購物車</button>
                  <p class='stock'>參考庫存<5</p>
              </div>
          </div>
          <div class='article'>
              <p class='content_title'>內容簡介</p>
              <div class='divider2'></div>
              <p class='content_article'>123</p>
              <p class='content_title'>作者簡介</p>
              <div class='divider2'></div>
              <p class='content_article'>123</p>
          </div> -->
            
        
        </div>
  </div>
    
  </div>
  


</body>
</html>
