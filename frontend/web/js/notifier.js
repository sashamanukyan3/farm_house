/**
 * Created by Бекарыс on 16.02.2016.
 */
function showNotify(title, message, url)
{
    var notify = $.notify(
        {
            title: title,
            message: message,
            url: url,
            target: '_blank'
        },
        {
            type: "info",
            animate: {
                enter: 'animated fadeInRight',
                exit: 'animated fadeOutRight'
            },
            offset: {
                x: 50,
                y: 100
            },
            delay: 2900,
        });
}

setInterval(function() {
    checkUpdates();
}, 3000);