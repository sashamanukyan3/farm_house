$(".mainProfile-btn").click(function(){

    $('.msg_response_profile').html('');

    var validate = $('.msg_response_profile').hide();
    var mailing = $("#mailing option:selected").val();
    var sex = $("#sex option:selected").val();
    var userId = $("#userId").text();

    if(mailing == "" || sex == "" || userId == ""){
        validate.append('Все поля должны быть заполнены!');
        validate.css('color','red');
        validate.show();
    }else{
        $.ajax({
            url: "/" + window.appLang + "/ajax/profile/",
            type: "POST",
            async:true,
            data: {'mailing': mailing, 'sex': sex, 'userId': userId}
        }).done(function(result){
            if(result.status){
                validate.append(result.msg);
                validate.css('color','green');
                validate.show();
            }else{
                validate.css('color','red');
                validate.append(result.msg);
                validate.show();
            }
        });

    }

});

$(".mainPassword-btn").click(function(){

    $(".msg_response_pass").html('');

    var password = $("#changepasswordform-password").val();
        password = $.trim(password);
    var repeatPassword = $("#changepasswordform-repeatpassword").val();
        repeatPassword = $.trim(repeatPassword)
    var validate = $('.msg_response_pass').hide();

    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    var oldPassword = $('#changepasswordform-oldpassword').val();
    if(password == "" || repeatPassword == "" || oldPassword == ""){
        validate.append('Все поля должны быть заполнены!');
        validate.css('color','red');
        validate.show();

    }else {

        if(password == repeatPassword) {

            $.ajax({
                url: "/ajax/password/",
                type: "POST",
                async: true,
                data: {'password': password, 'repeatPassword': repeatPassword, '_csrf': csrfToken, 'oldPassword':oldPassword},
                beforeSend: function () {
                    $(".loader-modal").show();
                },
                complete: function () {
                    $(".loader-modal").hide();
                }
            }).done(function (result) {
                if (result.status) {
                    validate.append(result.msg);
                    validate.css('color', 'green');
                    validate.show();
                    $("#changepasswordform-password").val('');
                    $("#changepasswordform-repeatpassword").val('');
                    $('#changepasswordform-oldpassword').val('');
                } else {
                    validate.css('color', 'red');
                    validate.append(result.msg);
                    validate.show();
                }
            });

        }else{
            validate.append('Error');
            validate.css('color','red');
            validate.show();
        }
    }

});

$(".pay_pass").click(function(){

    $(".msg_response_paypass").html('');
    var validate = $('.msg_response_paypass').hide();

    var csrfToken = $('meta[name="csrf-token"]').attr("content");

    $.ajax({
        url: "/ajax/paypass/",
        type: "POST",
        async: true,
        data: {'_csrf': csrfToken},
    }).done(function (result) {
        if (result.status) {
            validate.append(result.msg);
            validate.css('color', 'green');
            validate.show();
        } else {
            validate.css('color', 'red');
            validate.append(result.msg);
            validate.show();
        }
    });

});