<html>
    <title>PHP送出表單不用重新整理頁面 - TechMarks劃重點</title>
    <head>
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script type="text/javascript" src="test.js"></script>
    </head>
    <body>
        <form id="myForm" method="post">
            Name: <input name="name" id="name" type="text" /><br />
            Phone:<input name="phone" id="phone" type="text" /><br />
            Address: <input name="address" id="address" type="text" /><br />
            Delivery Time: <input name="dely_time" type="radio" value="morning">Morning(9-12)
            <input name="dely_time" type="radio" value="afternoon">Afternoon(12-18)
            <input name="dely_time" type="radio" value="night">Night(18-20)<br />
            <input type="button" id="submitData" onclick="SubmitFormData();" value="Submit" />
        </form>
        <br/>
        傳送的資料將顯示下邊..... <br />
        ==============================<br />
        <div id="results">
            <!-- 填入表單內容會秀在這 -->
        </div>
    </body>
</html>
