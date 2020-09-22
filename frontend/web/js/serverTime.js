/**
 * Created by Бекарыс on 15.01.2016.
 */

function getServerTime($spanClass)
{
    var d = new Date(timer);
    var months = new Array('Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря');
    var currentYear = d.getFullYear();
    var month = d.getMonth();
    var currentMonth = months[month];
    var currentDate = d.getDate();
    currentDate = currentDate < 10 ? '0'+currentDate : currentDate;

    var hours = d.getHours();
    var minutes = d.getMinutes();
    var seconds = d.getSeconds();
    minutes = minutes < 10 ? '0'+minutes : minutes;
    seconds = seconds < 10 ? '0'+seconds : seconds;
    var strTime = hours + ':' + minutes+ ':' + seconds;
    //$(".server-time").html(currentMonth+' ' + currentDate+' , ' + currentYear + ' ' + strTime) ;
    $spanClass.html(currentDate+' ' + currentMonth + ', ' + strTime) ;

    flag = false;
    timer = timer + 1000;
}