/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
import './styles/style.scss';

const $= require("jquery");
global.$ =global.jQuery = $;

require("bootstrap");

$(document).ready(function(){

    $(window).scroll(function(){
        if ($(window).scrollTop()>200) {             
            $("#myBtnScroll").css({display: "block"});             
            $("#navjs").css({position: "absolute"});
            $(".navmilieu").css({height: "60px"});

        }else{
            $("#myBtnScroll").css({display: "none"}); 
            $("#navjs").css({position: "fixed"});
            $(".navmilieu").css({height: "50px"});
        }

    });

    $("#closPanier").on("click", function(event){            
        // $("#panier").css({
        //     "width":"30vw",
        //     "display":"none",
        // }).show().animate({width:"0"}, 1500)          
        $("#panier").css({display: "none"}); 

    });

    $(".showPanier").on("click", function(event){ 
        if ($(window).width()<=500) {
            $("#panier").css({
                "width":"0",
                "display":"block",
            }).show().animate({width:"100vw"}, 1000) 
        }else if ($(window).width()>995 ) {
            $("#panier").css({
                "width":"0",
                "display":"block",
            }).show().animate({width:"30vw"}, 1000)            
        }else{
            $("#panier").css({
                "width":"0",
                "display":"block",
            }).show().animate({width:"60vw"}, 1000)
        }
    }); 

    $('.scroll').on('click', function() { // Au clic sur un élément
        var page = $("#header"); // Page cible
        var speed = 900; // Durée de l'animation (en ms)
        $('html, body').animate( { scrollTop: $(page).offset().top }, speed ); // Go
        return false;
    });

        
})

// window.addEventListener('scroll', () => {  
//     let scrollTop = document.documentElement.scrollTop;        
//     document.querySelector('#header').style.width = 100 + scrollTop / 5 + '%';
// });


