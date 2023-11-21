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
            this.#slider.push(item.classList.value.split(' '));
            item.remove();
        }

        for(let slide of allSlides) { //вот тут лучше не трогать
            const allSlidesClasses = slide.classList.value.split(' ');
            const allSlideMainClass = allSlidesClasses[1];
            if (!this.#slider.map(item => item[1]).includes(allSlideMainClass)) {
                this.#slider.push(slide.classList.value.split(' '));
                console.log(this.#slider);
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

        for(let item of this.#slider[this.#step]) {
            slide.classList.add(item);
        }
        
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
    slides  = null;

    constructor(slider) {
        this.#slider = slider;
        this.slides = document.body.querySelectorAll('.slide');
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