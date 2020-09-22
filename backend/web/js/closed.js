/**
* Created by ABC soft on 14.03.2016.
*/
$("body").on('click','.closed', function(){

    var id = $(".id").text();
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    $(this).removeClass().addClass('open');
    $(this).text('Открыть');

    $.ajax({
        url: "/raimin/support/closed",
        type: "POST",
        async: true,
        data: {'id': id, '_csrf': csrfToken}
    }).done(function (result) {
        if (result.status) {
            $(".form").css({'display':'none'});
        }
    });


});

$("body").on('click','.open', function(){

    var id = $(".id").text();
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    $(this).removeClass().addClass('closed');
    $(this).text('Закрыть');

    $.ajax({
        url: "/raimin/support/open",
        type: "POST",
        async: true,
        data: {'id': id, '_csrf': csrfToken}
    }).done(function (result) {
        if (result.status) {
            $(".form").css({'display':'block'});
        }
    });


});