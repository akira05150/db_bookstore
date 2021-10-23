# db_bookstore
請將分支改為master下載

## 說明
這是一個線上書城結合資料庫的網站，使用PHP做為後端語言，其中書籍資料、作者簡介內容、封面圖片皆來自**金石堂網站**
若要使用請下載xampp，並將Cart資料夾放入xampp\htdocs資料夾
路徑舉例：D:\xampp\htdocs\Cart

UI設計可使用AdobeXD或Figma

書籍資料要建入資料庫是一項大工程，可使用網頁爬蟲並整理輸出成Sql字串

## 功能
1. 首頁
![image](https://user-images.githubusercontent.com/70078018/138567946-8a6077c8-72bb-4ada-a67d-cb51b7e60b9e.png)
* 書籍依銷量排行顯示十筆資料於首頁
* 左側導覽列可進入書籍分類區
* 上方查詢欄，可以查詢作者或書名
* 右上角購物車ICON可點擊查看購物車

2. 書籍分類
![image](https://user-images.githubusercontent.com/70078018/138567995-5fb4e01f-a056-46ea-9a29-4bfbde301c9d.png)
進入分類頁，顯示依出版日期排序及依銷量排序的文學類書籍

3. 全館查詢
![image](https://user-images.githubusercontent.com/70078018/138568010-96923a4a-262d-4507-9ab7-e518b7cec31e.png)

4. 商品細節展示
![image](https://user-images.githubusercontent.com/70078018/138568013-475ae863-ce2b-49ba-a392-dcf45b9a12a9.png)

5. 購物車
![image](https://user-images.githubusercontent.com/70078018/138568019-b5941dc0-d725-463a-b01b-23fdb2b580e8.png)

6. 訂單細節內容
![image](https://user-images.githubusercontent.com/70078018/138568027-56e4ff87-a657-43aa-bbb4-df01d62fbb3d.png)

## Schema
![image](https://user-images.githubusercontent.com/70078018/138568042-9f373869-4de6-4d37-afaf-d7771d1312fa.png)
![image](https://user-images.githubusercontent.com/70078018/138568046-515f5c3f-e0da-4c56-a4b1-605eb07cafa1.png)
![image](https://user-images.githubusercontent.com/70078018/138568052-fe5ef097-b179-4fc5-b7c9-1ad13b215b1d.png)

## 未來改進之處
1. 新增登入功能
2. 建立網頁管理員頁面
3. 新增查詢排序條件，如依照出版日新舊、依照價格等
