$(document).ready(function () {
    $('#publish').on('click',function () {
        validateForm();
    });

    $('#title').on('change', function (e) {
        validateName($('#store_name_store').val());
    });

    $('#store_name_store').on('change', function (e) {
        validateName($('#store_name_store').val());
    });

    $('#store_phone_store').on('change',function (e) {
        validatePhoneNumber($('#store_phone_store').val());
    });
    function validateName(name_store) {
        if(name_store.length > 100){
            $('#error_name').addClass('active');
            $('#error_name').removeClass(' none-active');
        }else{
            $('#error_name').removeClass('active');
            $('#error_name').addClass(' none-active');
            $('form :submit').removeAttr("disabled", "disabled");
        }
    }

    function validatePhoneNumber(phone_number) {
        var regex = /^(0|84|\+84)+(3[2-9]|9[0-4|6-9]|7[0|6-9]|8[1-6|8-9]|5[6|8|9])+([0-9]{7})$/;
        phone_number = phone_number.trim();
        if(phone_number.length > 9 && regex.test(phone_number)){
            $('#error_phone').removeClass('active');
            $('#error_phone').addClass(' none-active');
            $('form :submit').removeAttr("disabled", "disabled");
        }else{
            $('#error_phone').addClass('active');
            $('#error_phone').removeClass(' none-active');
        }
    }

    function validateForm() {
        if($('#store_name_store').val().length == 0){
            $('form :submit').attr("disabled", "disabled");
        }
        if($('.error-message').hasClass('active')){
            $('form :submit').attr("disabled", "disabled");
        }
    }
});
