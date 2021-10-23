function add_toCart() {
    var isbn = $("#isbn").val();
    var quantity = $("#quantity").val();
    $.post("insertCart.php", { isbn: isbn, quantity: quantity},
        function(data) {
            $('#results').html(data);
            $('#cartForm')[0].reset();
        });
    alert("已將商品加入購物車！");
}

function qchange(index) {

    var tag_isbn = "#isbn"+String(index);
    var tag_quantity = "#Quantity"+String(index);
    var tag_price = "#price"+String(index);
    var tag_detail = "#detail"+String(index);

    var isbn = $(tag_isbn).val();
    var quantity = $(tag_quantity).val();
    var detail = $(tag_detail).val();
    var count = $('#count').val();


    $.post("cart_change.php", { isbn: isbn, quantity: quantity, detail: detail },
        function(data) {
            $('#results').html(data);
            $(tag_price).html("共"+ (quantity*detail) +"元");

            //get每個tag_price價錢得總價
            var total = 0;
            for(var i=1; i<=count; i++){

                tag_quantity = "#Quantity"+String(i);
                tag_detail = "#detail"+String(i);
                quantity = $(tag_quantity).val();
                detail = $(tag_detail).val();
                total += quantity*detail;
            }
            $('#total').html(total+"元");
        });
}


