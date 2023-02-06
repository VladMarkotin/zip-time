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
            $(".smooth-section").nextPage();
        } else if (event.originalEvent.detail < 0 || event.originalEvent.wheelDelta > 0 || event.keyCode == 38) {
            // Previous section element
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
/*Hidden*/
const observer = new IntersectionObserver((enteries) => {
  enteries.forEach((entry) => {
    if (entry.isIntersecting){
      entry.target.classList.add('show')
    } else {
      entry.target.classList.remove('show')
    }
  })
})

const hiddenElements = document.querySelectorAll('.hidden')
hiddenElements.forEach((el) => observer.observe(el))
/*Faq*/
class Faq {
  constructor(target, config) {
    this._el = typeof target === 'string' ? document.querySelector(target) : target
    const defaultConfig = {
      alwaysOpen: true,
      duration: 350
    };
    this._config = Object.assign(defaultConfig, config);
    this.addEventListener()
  }
  addEventListener() {
    this._el.addEventListener('click', (e) => {
      const elHeader = e.target.closest('.faq_header')
      if (!elHeader) {
        return;
      }
      if (!this._config.alwaysOpen) {
        const elOpenItem = this._el.querySelector('.faq_item_show')
        if (elOpenItem) {
          elOpenItem !== elHeader.parentElement ? this.toggle(elOpenItem) : null
        }
      }
      this.toggle(elHeader.parentElement)
    });
  }
  show(el) {
    const elBody = el.querySelector('.faq_body')
    if (elBody.classList.contains('collapsing') || el.classList.contains('faq_item_show')) {
      return;
    }
    elBody.style['display'] = 'block'
    const height = elBody.offsetHeight
    elBody.style['height'] = 0;
    elBody.style['overflow'] = 'hidden'
    elBody.style['transition'] = `height ${this._config.duration}ms ease`
    elBody.classList.add('collapsing')
    el.classList.add('faq_item_slidedown')
    elBody.offsetHeight;
    elBody.style['height'] = `${height}px`
    window.setTimeout(() => {
      elBody.classList.remove('collapsing')
      el.classList.remove('faq_item_slidedown')
      elBody.classList.add('collapse')
      el.classList.add('faq_item_show')
      elBody.style['display'] = 'block'
      elBody.style['height'] = ''
      elBody.style['transition'] = ''
      elBody.style['overflow'] = ''
    }, this._config.duration)
  }
  hide(el) {
    const elBody = el.querySelector('.faq_body')
    if (elBody.classList.contains('collapsing') || !el.classList.contains('faq_item_show')) {
      return;
    }
    elBody.style['height'] = `${elBody.offsetHeight}px`
    elBody.offsetHeight
    elBody.style['display'] = 'block'
    elBody.style['height'] = 0
    elBody.style['overflow'] = 'hidden'
    elBody.style['transition'] = `height ${this._config.duration}ms ease`
    elBody.classList.remove('collapse')
    el.classList.remove('faq_item_show')
    elBody.classList.add('collapsing')
    window.setTimeout(() => {
      elBody.classList.remove('collapsing')
      elBody.classList.add('collapse')
      elBody.style['display'] = ''
      elBody.style['height'] = ''
      elBody.style['transition'] = ''
      elBody.style['overflow'] = ''
    }, this._config.duration);
  }
  toggle(el) {
    el.classList.contains('faq_item_show') ? this.hide(el) : this.show(el);
  }
}

new Faq(document.querySelector('.faq'), {
  alwaysOpen: false
})