/**
 * Created by Бекарыс on 18.01.2016.
 */
// Change background depending on user’s time
function applyclass()
{
    var d = new Date();
    var n = d.getHours();
    var e = $('.wrapper');
    if(n > 7 && n < 21)
    {
        e.removeClass('body-bg-n');
        e.addClass('body-bg-d');
    }
    else
    {
        e.removeClass('body-bg-d');
        e.addClass('body-bg-n');
    }
}
applyclass();
