/**
 * Created by ismail on 07/12/2017.
 */
<<<<<<< HEAD
$(document).ready(function(){
    $('#headerContainer--arrow').click(function(){
        $('html,body').animate({
            scrollTop: $('#steps').offset().top - 10
        }, 500);
    });

    window.addEventListener('scroll', function(e){
        var distanceY = window.pageYOffset || document.documentElement.scrollTop,
            shrinkOn = 100,
            header = document.querySelector("header");
        if (distanceY > shrinkOn) {
            classie.add(header,"sticky");
        } else {
            if (classie.has(header,"sticky")) {
                classie.remove(header,"sticky");
            }
        }
    });
});
=======
>>>>>>> 5c057f204b57577ebd6ae58b95fca4657372f36c
