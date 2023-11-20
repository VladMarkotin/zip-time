class Slider {

    #slider          = null;
    #sliderWrapper   = null;
    #currentWidth    = null;
    #step            = null;
    #offset          = null;
    #sliderLeftArrow = null;

    init() {
        const slides = document.body.querySelectorAll('.slide');
        this.#slider = new Array;
        this.#sliderWrapper = document.querySelector('.slider-wrapper');
        this.#currentWidth = window.innerWidth;
        this.#sliderLeftArrow = document.querySelector('.slider-left-arrow-wrapper');

        for (let item of slides) {
            this.#slider.push(item.classList.value.split(' '));
            item.remove();
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

const slider = new Slider;
slider.init();

window.addEventListener('resize', () => {
    slider.init();
});