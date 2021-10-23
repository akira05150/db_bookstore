<?php

if(!isset($_COOKIE["uid_temp"])){
  // 設定未登入暫時ID
  $uid_temp = uniqid($more_entropy = true); //生成唯一ID
  setcookie("uid_temp", $uid_temp , time()+ 3600*24*30 );
  //echo $_COOKIE["uid_temp"];
}
else{
  //echo $_COOKIE["uid_temp"];
}

// setcookie( "test", "", time()-3600); //釋放cookie


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


$sql = "select ISBN,Title,Price,Sells from book ORDER BY Sells DESC LIMIT 10";
$result = $db->query($sql);
// while($row=$result->fetch(PDO::FETCH_OBJ)){   
//         //PDO::FETCH_OBJ 指定取出資料的型態
//         echo "Sells".$row->Sells."<br>"; // 銷量
//         echo "ISBN".$row->ISBN."<br>"; //for cover
//         echo "Title".$row->Title."<br>"; // 書名
//         echo "Price".$row->Price."<br>"; // 價錢
//     }
?>


<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="./css/styles.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto Sans TC">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
    <!-- <input type="button" class="goCart_icon"> -->
    <!-- 登入鍵 -->
    <input type="button" class="login" Value="Log in">
  </div>

  <div class="content">
    <div class="nav_bar">
    <!-- 分類頁 -->
    <div class="dropdown">
      <p class="catagory" style="display:block; margin-top: 4.72vh;">中文書</p>
      <div class="dropdown-content">
        <a href="http://localhost/Cart/catagory.php?catagory=中文書&subcatagory=文學">文學</a>
        <div class="divider_nav_sub"></div>
        <a href="http://localhost/Cart/catagory.php?catagory=中文書&subcatagory=財經">財經</a>
        <div class="divider_nav_sub"></div>
        <a href="#">藝術</a>
        <div class="divider_nav_sub"></div>
        <a href="#">生活</a>
    </div>
    </div>
    <div class="divider_nav"></div>

    <div class="dropdown">
      <p class="catagory" style="display:block; margin-top: 4.72vh;">英文書</p>
      <div class="dropdown-content">
        <a href="#">文學</a>
        <div class="divider_nav_sub"></div>
        <a href="#">財經</a>
        <div class="divider_nav_sub"></div>
        <a href="#">藝術</a>
        <div class="divider_nav_sub"></div>
        <a href="#">生活</a>
    </div>
    </div>
    <div class="divider_nav"></div>
    </div>

    <!-- 排行榜內容 -->
    <div class="rank_content">
      <p class="title_text">即時排行榜</p>
      <div class="divider"></div>

      <div class="rank_slide">

      <?php
          //PDO::FETCH_OBJ 指定取出資料的型態
          while($row=$result->fetch(PDO::FETCH_OBJ)){

            echo 
              "<div class='rank_items'>
                <div class='cover' style='background-image: url(./img/cover/".$row->ISBN.".jpg);'>
                </div>
                <div class='title_area'>
                  <a href='http://localhost/Cart/book_detail.php?isbn=".$row->ISBN."' class='book_title'>".$row->Title."</a>
                </div>
                <p class='price' style='text-align:left;'>".$row->Price."元</p>
              </div>";
            
            // echo "ISBN".$row->ISBN."<br>"; //for cover
            // echo "Title".$row->Title."<br>"; // 書名
            // echo "Price".$row->Price."<br>"; // 價錢
            // echo "Sells".$row->Sells."<br>"; // 銷量
          }
      ?>
        
        
      </div>
    </div>

  </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js" integrity="sha512-HGOnQO9+SP1V92SrtZfjqxxtLmVzqZpjFFekvzZVWoiASSQgSr4cw9Kqd2+l8Llp4Gm0G8GIFJ4ddwZilcdb8A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">
    $('.rank_slide').slick({
      dots: true,
      infinite: true,
      slidesToShow: 3,
      slidesToScroll: 3,
      //arrows: true,
      prevArrow:"<img class='a-left control-c prev slick-prev' src='./img/left-arrow.png'>",
      nextArrow:"<img class='a-right control-c next slick-next' src='./img/right-arrow.png'>"
    });
			
</script>
</body>
</html>
