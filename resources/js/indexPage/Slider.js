class SlideItem {

    content = null;
    classes = null;

    constructor(classes, content) {
        this.classes = classes;
        this.content = content;   
    }
}

class Slider {

    #slider          = null;
    #sliderWrapper   = null;
    #currentWidth    = null;
    #step            = null;
    #offset          = null;
    #sliderLeftArrow = null;

    init(allSlides) {
        const slides = document.body.querySelectorAll('.slide');
        this.#slider = new Array;
        this.#sliderWrapper = document.querySelector('.slider-wrapper');
        this.#currentWidth = window.innerWidth;
        this.#sliderLeftArrow = document.querySelector('.slider-left-arrow-wrapper');

        for (let item of slides) {
            this.#slider.push(new SlideItem(item.classList.value.split(' '), item.innerHTML));
            item.remove();
        }

        for(let slide of allSlides) { //вот тут лучше не трогать
            const allSlidesClasses = slide.classes;
            const allSlideMainClass = allSlidesClasses[1];
            
            if (!this.#slider.map(item => item.classes[1]).includes(allSlideMainClass)) {
                this.#slider.push(slide);
            }
        }
        
        this.#step   = 0;
        this.#offset = 0;

        this.draw();
        this.draw();

        this.left = this.left.bind(this);
        this.#sliderLeftArrow.onclick=this.left;
    }

    draw() {
        const slide = document.createElement('div');
        const currentItem = this.#slider[this.#step];

        for(let item of currentItem.classes) {
            slide.classList.add(item);
        }

        slide.innerHTML = currentItem.content;
        
        slide.style.left = this.#offset * this.#currentWidth + 'px';
        this.#sliderWrapper.appendChild(slide);
    
        if (this.#step + 1 === this.#slider.length) {
            this.#step = 0;
        } else {
            this.#step++;
        }
        this.#offset = 1;
    }

    left() {
        this.#sliderLeftArrow.onclick = null;
        const slides = document.querySelectorAll('.slide');
        let offset = 0;

        for (let item of slides) {
            item.style.left = offset * this.#currentWidth - this.#currentWidth + 'px';
            offset++;
        }

        setTimeout(() => {
            slides[0].remove();
            this.draw();
            this.#sliderLeftArrow.onclick=this.left;
        }, 600);
    }
}

class SliderFacade {
    #slider = null;
    slides  = new Array;

    constructor(slider) {
        this.#slider = slider;
        const slides = document.body.querySelectorAll('.slide');
        for (let item of slides) {
            this.slides.push(new SlideItem(item.classList.value.split(' '), item.innerHTML));
        }
    }
    
    init() {
        this.#slider.init(this.slides);
    }
}

const slider = new SliderFacade(new Slider);
slider.init();

window.addEventListener('resize', () => {
    slider.init();
});