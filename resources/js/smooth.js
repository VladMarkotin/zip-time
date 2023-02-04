/*Smooth*/
let pagesMax = 0;

$(document).ready(function(){


    // Create navigation list
    $("body").append("<ul class='smooth-navigation-menu'></li></ul>");


    // Define section classes
    $(".smooth-section").each(function(index){
        $(this).addClass("smooth-section-"+index);
        pagesMax++;

        // Add section on navigation list
        $(".smooth-navigation-menu").append("<li class='smooth-navigation-item' data-section='"+index+"'></li>");

    });


    // Item navigation list event
    $(".smooth-navigation-item").click(function(){
        let section = $(this).attr("data-section");
        $("html, body").stop().animate({scrollTop: $(".smooth-section-"+section).offset().top},1000);
        pageIndex = section;
    });


    // Define CSS default styles...
    $(this).defineCss();

});


// Control scroll time
let time = new Date().getTime();

// Scroll events (mouse and keys)
$(window).bind("keydown.key40 DOMMouseScroll mousewheel",function(event){


    // Update time
    let now = new Date().getTime();

    // Check page refresh. (F5)
    if(event.keyCode == 116){
        location.reload();
    }


    // Check time of scrolling...
    if (now - time >= 100) {
        time = now;
        // Down event
        if (event.originalEvent.detail > 0 || event.originalEvent.wheelDelta < 0 || event.keyCode == 40) {
            // Next section element
            console.log('nextPage');
            $(".smooth-section").nextPage();
        } else if (event.originalEvent.detail < 0 || event.originalEvent.wheelDelta > 0 || event.keyCode == 38) {
            // Previous section element
            console.log('prevPage');
            $(".smooth-section").prevPage();
        }

        event.stopPropagation();
    } else {
        time = now;
        return 0;
    }

});


// Section index number/position
pageIndex = 0;

// Next section function
$.fn.nextPage = function () {
    if(pageIndex < pagesMax-1){

        pageIndex++;

        let top = $(this).next(".smooth-section-"+pageIndex).offset().top;
        $("html, body").stop().animate({scrollTop: top},1000);

    }

};

// Previous section function
$.fn.prevPage = function () {
    if(pageIndex > 0){

        pageIndex--;

        let top = $(this).prev(".smooth-section-"+pageIndex).offset().top;
        $("html, body").stop().animate({scrollTop: top},1000);

    }

};



// Define styles...
$.fn.defineCss = function(){

    // Width and Height 100% //
    $("html, body").css({"width":"100%","height":"100%"});


    // Remove scrollbar
    $(".no-scroll").css({"overflow": "hidden"});


    // Define small size to element (200px)
    $(".smooth-small").each(function(){
        $(this).css({"width":"100%","height":"200px"});
    });


    // Define middle size to element (50%)
    $(".smooth-middle").each(function(){
        $(this).css({"width":"100%","height":"50%"});
    });


    // Define full size to element (100%)
    $(".smooth-full").each(function(){
        $(this).css({"width":"100%","height":"100%"});
    });


    // Realize parallax effect
    $(".smooth-parallax").each(function(){

        let parallax = $(this);

        $(window).scroll(function() {
            var scrollPosition = -($(window).scrollTop() / 5);

            var imagePosition = '50% '+ scrollPosition + 'px';

            parallax.css('background-position', imagePosition );

        });
    });
};