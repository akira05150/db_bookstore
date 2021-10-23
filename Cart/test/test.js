function SubmitFormData() {
    var name = $("#name").val();
    var phone = $("#phone").val();
    var address = $("#address").val();
    var dely_time = $("input[type=radio]:checked").val();
    $.post("submit.php", { name: name, phone: phone, address: address, dely_time: dely_time },
        function(data) {
            $('#results').html(data);
            $('#myForm')[0].reset();
        });
    }
