/*Smooth*/
let pagesMax = 0;
let time = new Date().getTime();
let limit = 250;
let pageIndex = localStorage.getItem("pageIndex");
localStorage.removeItem("pageIndex");

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

//Document ready
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

  let throttle = (func, limit) => {
    let inThrottle;
    return function () {
      const args = arguments;
      const context = this;
      if (!inThrottle) {
        func.apply(context, args);
        inThrottle = true;
        setTimeout(() => (inThrottle = false), limit);
      }
    };
  };

  $(window).bind("keydown.key40 DOMMouseScroll mousewheel",
    throttle(function (event) {
      let now = new Date().getTime();
      if (now - time >= 100) {
        time = now;
        if (event.keyCode === 116) {
          localStorage.setItem("pageIndex", pageIndex);
          location.reload();
        } else if (event.keyCode == 40 || event.originalEvent.detail > 0 || event.originalEvent.wheelDelta < 0) {
          $(".smooth-section").nextPage();
        } else if (event.keyCode == 38 || event.originalEvent.detail < 0 || event.originalEvent.wheelDelta > 0) {
          $(".smooth-section").prevPage();
        }
        event.stopPropagation();
      }
    }, limit)
  );
});