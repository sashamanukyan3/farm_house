$("body").on("click", ".close_msg", function(){

    $(".msg_response").hide();
    $(".msg_response").text('');
    $(".msg_response").append('<a class="close_msg" href="javascript:void(0);">&times;</a>');

});