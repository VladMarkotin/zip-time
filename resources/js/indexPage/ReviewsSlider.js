class ReviewsSlider {
    #slider               = null;
    #sliderLine           = null;
    #sliderItems          = null;
    #sliderItemsCounter   = null;
    #sliderWidth          = null;
    #sliderButtonsWrapper = null;

    init() {
        this.#slider =  document.querySelector('.reviews-slider');
        this.#sliderLine = this.#slider.querySelector('.reviews-slider-line');
        this.#sliderItems = this.#sliderLine.querySelectorAll('.reviews-slide');
        this.#sliderItemsCounter = this.#sliderItems.length;
        this.#sliderWidth = getComputedStyle(this.#slider).width;
        this.#sliderButtonsWrapper = document.querySelector('.reviews-slider-buttons');

        this.#sliderLine.style.width = Number.parseInt(this.#sliderWidth) * this.#sliderItemsCounter;
        
        this.cleanButtonWrapper();
        this.#sliderItems.forEach((item, index) => {
            item.style.width = this.#sliderWidth;
            this.createButton(index);
        })
        
    }

    cleanButtonWrapper() {
        this.#sliderButtonsWrapper.innerHTML = '';
    }

    createButton(index) {
        if (this.#sliderItemsCounter) {
            const activeClassVal = 'reviews-slider-active-button';
    
            const sliderButton = document.createElement('button');
            sliderButton.classList.add('reviews-slider-button');
            if (!index) sliderButton.classList.add(activeClassVal);

            sliderButton.addEventListener('click', (e) => {
                
                for (const item of this.#sliderButtonsWrapper.querySelectorAll('.reviews-slider-button')) {
                    if (item.classList.contains(activeClassVal)) item.classList.remove(activeClassVal)
                }

                e.target.classList.add(activeClassVal);
                
                this.#sliderLine.style.left = `-${Number.parseInt(this.#sliderWidth)  * index}px`
            })
    
            this.#sliderButtonsWrapper.append(sliderButton);
        }
    }
}

const reviewsSlider = new ReviewsSlider;
reviewsSlider.init();

window.addEventListener('resize', () => {
    reviewsSlider.init();
});