class PhilosofySlider {
    #slider               = null;
    #sliderLine           = null;
    #sliderItems          = null;
    #sliderItemsCounter   = null;
    #sliderWidth          = null;
    #sliderButtonsWrapper = null;
    #activeClassVal       = null;
    #currentSlideIndex    = 0;

    init() {
        this.#slider =  document.querySelector('.philosofy-slider');
        this.#sliderLine = this.#slider.querySelector('.philosofy-slider-line');
        this.#sliderItems = this.#sliderLine.querySelectorAll('.philosofy-slide');
        this.#sliderItemsCounter = this.#sliderItems.length;
        this.#sliderWidth = getComputedStyle(this.#slider).width;
        this.#sliderButtonsWrapper = document.querySelector('.philosofy-slider-buttons');
        this.#activeClassVal = 'philosofy-slider-active-button';

        this.move = this.move.bind(this)

        this.#sliderLine.style.width = Number.parseInt(this.#sliderWidth) * this.#sliderItemsCounter + 'px';
        
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
            const sliderButton = document.createElement('button');
            sliderButton.classList.add('philosofy-slider-button');
            if (index === this.#currentSlideIndex) sliderButton.classList.add(this.#activeClassVal);

            sliderButton.addEventListener('click', (e) => {
                this.move(index, e);
            })
    
            this.#sliderButtonsWrapper.append(sliderButton);
        }
    }

    move(index, e) {
        const sliderButtons = this.#sliderButtonsWrapper.querySelectorAll('.philosofy-slider-button');

        for (const item of sliderButtons) {
            if (item.classList.contains(this.#activeClassVal)) item.classList.remove(this.#activeClassVal)
        }

        if (e) e.target.classList.add(this.#activeClassVal);
        else sliderButtons[index].classList.add(this.#activeClassVal);
        
        this.#sliderLine.style.left = `-${Number.parseInt(this.#sliderWidth)  * index}px`
        this.#currentSlideIndex = index;
    }

    get currentSlideIndex() {
        return this.#currentSlideIndex;
    }
}

export default PhilosofySlider;
