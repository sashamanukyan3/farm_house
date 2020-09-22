/**
 * Created by Бекарыс on 10.02.2016.
 */

// Change background depending on user’s time for game pages
function applyclass()
{
    var d = new Date();
    var n = d.getHours();

    if(n > 7 && n < 21)
    {
        $('html').css({"background": "url(../img/bgiday.png) no-repeat fixed",
            "-webkit-background-size": "cover",
            "-moz-background-size": "cover",
            "-o-background-size": "cover",
            "background-size": "cover"
        });

        $('body').css({"background": "url(../img/gameday.png)",
            "-webkit-background-size": "cover",
            "-moz-background-size": "cover",
            "-o-background-size": "cover",
            "background-size": "cover"});
    }
    else
    {
        $('html').css({"background": "url(../img/bgnight.png) no-repeat fixed",
            "-webkit-background-size": "cover",
            "-moz-background-size": "cover",
            "-o-background-size": "cover",
            "background-size": "cover"
        });

        $('body').css({"background": "url(../img/gamenight.png)",
            "-webkit-background-size": "cover",
            "-moz-background-size": "cover",
            "-o-background-size": "cover",
            "background-size": "cover"});
    }
}
applyclass();
