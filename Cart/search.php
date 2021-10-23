<?php

$search_text = $_GET["search"];
if($search_text==""){
  //重定向瀏覽器
  header("Location:index.php");
  //確保重定向後，後續程式碼不會被執行
  exit;
}

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

//搜尋類似字串
$sql_search = "(SELECT BOOK.ISBN, BOOK.Title, BOOK.Publisher, BOOK.Price, AUTHOR.Aname
                FROM (BOOK
                  INNER JOIN WRITTEN
                  ON BOOK.ISBN=WRITTEN.ISBN
                  )
                    INNER JOIN AUTHOR
                  ON AUTHOR.Aid=WRITTEN.Aid
                WHERE AUTHOR.Aname LIKE '%".$search_text."%')
                UNION
                (SELECT BOOK.ISBN, BOOK.Title, BOOK.Publisher, BOOK.Price, AUTHOR.Aname
                FROM (BOOK
                  INNER JOIN WRITTEN
                  ON BOOK.ISBN=WRITTEN.ISBN
                  )
                    INNER JOIN AUTHOR
                  ON AUTHOR.Aid=WRITTEN.Aid
                WHERE BOOK.Title LIKE '%".$search_text."%')
                ;";

$result_search = $db->query($sql_search);
$row_count = $result_search->rowCount();

// 分頁
$per = 2;
$page_count = ceil($row_count/$per);


if (!isset($_GET["page"])){ //假如$_GET["page"]未設置
        $page=1; //則在此設定起始頁數
    } else {
        $page = intval($_GET["page"]); //確認頁數只能夠是數值資料
    }
    $start = ($page-1)*$per; //每一頁開始的資料序號
    $sql_search_page = "(SELECT BOOK.ISBN, BOOK.Title, BOOK.Publisher, BOOK.Price, AUTHOR.Aname
                FROM (BOOK
                  INNER JOIN WRITTEN
                  ON BOOK.ISBN=WRITTEN.ISBN
                  )
                    INNER JOIN AUTHOR
                  ON AUTHOR.Aid=WRITTEN.Aid
                WHERE AUTHOR.Aname LIKE '%".$search_text."%'
                LIMIT ".$start.", ".$per.")
                UNION
                (SELECT BOOK.ISBN, BOOK.Title, BOOK.Publisher, BOOK.Price, AUTHOR.Aname
                FROM (BOOK
                  INNER JOIN WRITTEN
                  ON BOOK.ISBN=WRITTEN.ISBN
                  )
                    INNER JOIN AUTHOR
                  ON AUTHOR.Aid=WRITTEN.Aid
                WHERE BOOK.Title LIKE '%".$search_text."%'
                LIMIT ".$start.", ".$per.")
                ;";
    $result_search_page = $db->query($sql_search_page);

//找不到的設置
if($row_count==0){
    $page=0;
    $page_count=0;
}
// try {
//   while($row=$result_search_page->fetch(PDO::FETCH_OBJ)){
//         echo "ISBN".$row->ISBN."<br>"; //for cover
//         echo "Title".$row->Title."<br>"; // 書名
//         echo "Price".$row->Price."<br>"; // 價錢
//         echo "Publisher".$row->Publisher."<br>";
//         echo "Author".$row->Aname."<br>";
//     }
// } catch (\Throwable $th) {
//   echo "查無資料";
// }


?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="./css/styles_search.css">
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

            <p class="title_text">搜尋結果</p>
            <div class="divider"></div>
            <p class="search_num">搜尋：<?php echo $search_text?>，全館搜尋共 <?php echo $row_count?> 筆，頁數 <?php echo $page."/".$page_count?></p>

            
              <?php
                  while($row=$result_search_page->fetch(PDO::FETCH_OBJ) ){
                    echo "
                    <div class='book'>
                      <div class='cover' style='background-image:url(./img/cover/".$row->ISBN.".jpg);'>
                          </div>
                          <div class='info'>
                              <a href='http://localhost/Cart/book_detail.php?isbn=".$row->ISBN."'   class='title'>".$row->Title."</a>
                              <p class='detail'>".$row->Aname." 著</p>
                              <p class='detail'>".$row->Publisher." 出版</p>
                              <p class='price'>".$row->Price."元</p>
                              <form id='cartForm' method='post' style='display:inline-block'>
                                <input id='isbn' name='isbn' type='hidden' value='".$row->ISBN."'>
                                <input id='quantity' name='quantity' type='hidden' value='1'>
                                <input type='button' class='add_book' onclick='add_toCart();' value='加入購物車' />
                              </form>
                          </div>
                      </div>
                      <div class='divider_long'></div>
                    ";
                  }   
              ?>
            
              <div class="page_container">
                <div class="pagination">
                  <?php 
                      //上一頁
                      if($row_count==0){}
                      else if($page!=1){
                        echo " <a href='search.php?search=".$search_text."&page=".($page-1)."'>&lt;</a>";
                      }

                      for($p=1; $p<=$page_count; $p++) {
                        if($p==$page){
                          echo"<a class='active' href='search.php?search=".$search_text."&page=".$p."'>".$p."</a>";
                        }
                        else{
                          echo"<a href='search.php?search=".$search_text."&page=".$p."'>".$p."</a>";
                        }
                      }

                      //下一頁
                      if($row_count==0){}
                      else if($page!=$page_count){
                        echo " <a href='search.php?search=".$search_text."&page=".($page+1)."'>&gt;</a>";
                      }
                  ?>
                  
                </div>
              </div>
          
        </div>

    </div>

  </div>

</body>
</html>
