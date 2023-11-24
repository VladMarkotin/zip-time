class ReviewsSlider {
    #slider             = null;
    #sliderLine         = null;
    #sliderItems        = null;
    #sliderItemsCounter = null;
    #sliderWidth        = null;

    init() {
        this.#slider =  document.querySelector('.reviews-slider');
        this.#sliderLine = this.#slider.querySelector('.reviews-slider-line');
        this.#sliderItems = this.#sliderLine.querySelectorAll('.reviews-slide');
        this.#sliderItemsCounter = this.#sliderItems.length;
        this.#sliderWidth = getComputedStyle(this.#slider).width;
        this.#sliderLine.style.width = Number.parseInt(this.#sliderWidth) * this.#sliderItemsCounter;

        this.#sliderItems.forEach((item, index) => {
            item.style.width = this.#sliderWidth;
            this.createButton(index);
        })
        
    }

    createButton(index) {
        if (this.#sliderItemsCounter) {
            const sliderButtonsWrapper = document.querySelector('.reviews-slider-buttons');
            const activeClassVal = 'reviews-slider-active-button';
    
            const sliderButton = document.createElement('button');
            sliderButton.classList.add('reviews-slider-button');
            if (!index) sliderButton.classList.add(activeClassVal);

            sliderButton.addEventListener('click', (e) => {
                
                for (const item of sliderButtonsWrapper.querySelectorAll('.reviews-slider-button')) {
                    if (item.classList.contains(activeClassVal)) item.classList.remove(activeClassVal)
                }

                e.target.classList.add(activeClassVal);
                
                this.#sliderLine.style.left = `-${Number.parseInt(this.#sliderWidth)  * index}px`
            })
    
            sliderButtonsWrapper.append(sliderButton);
        }
    }
}

const reviewsSlider = new ReviewsSlider;
reviewsSlider.init();
