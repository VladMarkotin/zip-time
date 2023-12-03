class SlideContentController {
    static #slideContentMap = [
        {
            number: 'one',
            method: 'initFirstSlide',
        },
        {
            number: 'two',
            method: 'initSecondSlide',
        },
        {
            number: 'three',
            method: 'initThirdSlide',
        },
    ]

    static #defaultTimerValue = 1600;

    static init(slideNumber) {
        const currentMethod = this.#slideContentMap.find(item => item.number === slideNumber).method;
        this[currentMethod]();
    }

    static initFirstSlide() {
        this.removeAddedClasses('slide-one-li-left', 'slide-one-li-right');

        const slideOneLiCollect = document.querySelectorAll('.slide-one-list .slide-one-li');
        const getTimer = this.getTimerCreator();
        const slideOneLiTimer = getTimer(slideOneLiCollect);
        
        for (let i = 0; i < slideOneLiCollect.length; i++) {
            const currentLi = slideOneLiCollect[i];
            const classAdded = i % 2 === 0 ? 'slide-one-li-left' : 'slide-one-li-right';

            setTimeout(() => {
                currentLi.classList.add(classAdded);
            }, slideOneLiTimer.next().value)
        }

        const sliderContetWrapper = document.querySelector('.slide-content');
        const slider3dText = sliderContetWrapper.querySelector('.slide-content-3d-title');
        const slider3dActiveClass = 'slide-content-3d-title-active';

        sliderContetWrapper.addEventListener('mouseenter', () => {
            slider3dText.classList.add(slider3dActiveClass);
        });

        sliderContetWrapper.addEventListener('mouseleave', () => {
            if (slider3dText.classList.contains(slider3dActiveClass)) slider3dText.classList.remove(slider3dActiveClass);
        })
    }

    static initSecondSlide() {
        this.removeAddedClasses('slide-content-subtitle-isshown', 'slide-one-li-left');
        
        const slideTwoWrapper = document.querySelector('.slide-two');
        const slideTwoSubtitle = slideTwoWrapper.querySelector('.slide-content-subtitle');
        const slideTwoLiCollect = slideTwoWrapper.querySelectorAll('.slide-two-list .slide-two-li');
        const getTimer = this.getTimerCreator(1000 ,2400);
        const slideTwoLiTimer = getTimer(slideTwoLiCollect);
        
        setTimeout(() => {
            slideTwoSubtitle.classList.add('slide-content-subtitle-isshown');

            for (let i = 0; i < slideTwoLiCollect.length;i++) {
                setTimeout(() => {
                    slideTwoLiCollect[i].classList.add('slide-one-li-left');
                }, slideTwoLiTimer.next().value);
            }
        }, this.#defaultTimerValue / 2)
    }

    static initThirdSlide() {
        // console.log('3')
    }
    
    static getTimerCreator(firstSlideTimerValue = 100 ,timerValue) {
        const defaultTimerValue = timerValue || this.#defaultTimerValue;

        return function* (items, interval = defaultTimerValue) {
            for (let i = 1; i <= items.length; i++) {
                if (i === 1) yield firstSlideTimerValue
                yield i * interval;
            }
        }
    }

    static removeAddedClasses(...classes) {
       classes.forEach((addedClass) => {
        const existsCurrentClassColl = document.querySelectorAll(`.${addedClass}`);

        for (let i = 0; i < existsCurrentClassColl.length; i++) existsCurrentClassColl[i].classList.remove(addedClass);
       })
    }
}

class SlideArrowController {
    #sliderWrapper   = null;
    #slideLeftArrow  = null;
    #className       = 'transparent'

    init() {
        this.#sliderWrapper = document.querySelector('.slider-wrapper');
        this.#slideLeftArrow = document.querySelector('.slider-left-arrow-wrapper');

        this.#sliderWrapper.addEventListener('mouseenter', () => {
            if (this.#slideLeftArrow.classList.contains(this.#className)) {
                this.#slideLeftArrow.classList.remove(this.#className);
            }
        })

        this.#sliderWrapper.addEventListener('mouseleave', () => {
            if (!this.#slideLeftArrow.classList.contains(this.#className)) {
                this.#slideLeftArrow.classList.add(this.#className);
            }
        })
    }
}

class SlideItem {

    content = null;
    classes = null;

    constructor(classes, content) {
        this.classes = classes;
        this.content = content;   
    }
}

class Slider {

    #slider                 = null;
    #sliderWrapper          = null;
    #currentWidth           = null;
    #step                   = null;
    #offset                 = null;
    #sliderLeftArrow        = null;
    #slideItem              = null;
    #slideContentController = null;

    init(slideItem, allSlides, slideContentController) {
        const slides = document.body.querySelectorAll('.slide');
        this.#slider = new Array;
        this.#sliderWrapper = document.querySelector('.slider-wrapper');
        this.#currentWidth = window.innerWidth;
        this.#sliderLeftArrow = document.querySelector('.slider-left-arrow-wrapper');
        this.#slideItem = slideItem;
        this.#slideContentController = slideContentController;

        for (let item of slides) {
            this.#slider.push(new this.#slideItem(item.classList.value.split(' '), item.innerHTML));
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
        this.initZeroSlide();
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
            this.initZeroSlide();
        }, 600);
    }

    initZeroSlide() {
        const zeroSlide = document.querySelector('.slider-wrapper > .slide');
        const regExpPattern = /^slide-(\w+)$/;

        const slideNumber = findSlideNumbe(zeroSlide);
        this.#slideContentController.init(slideNumber);

        const yeapButton = document.querySelector('.yeap-button');
        if (yeapButton) {
            yeapButton.addEventListener('click', () => {
                this.left();
            })
        }
        
        function findSlideNumbe(zeroSlide) {
            const allClasses = zeroSlide.classList;

            for (const item of allClasses) {
                const regExp = item.match(regExpPattern);
                if (regExp) {
                    return regExp[1];
                    break;
                }
            }
        }
        
    }
}

class SliderFacade {
    #slider                 = null;
    slides                  = new Array;
    #slideItem              = null;
    #slideContentController = null;

    constructor(slider, slideItem, slideContentController) {
        this.#slider = slider;
        this.#slideItem = slideItem;
        this.#slideContentController = slideContentController;

        const slides = document.body.querySelectorAll('.slide');
        for (let item of slides) {
            this.slides.push(new this.#slideItem(item.classList.value.split(' '), item.innerHTML));
        }
    }
    
    init() {
        this.#slider.init(this.#slideItem, this.slides, this.#slideContentController);
    }
}

const mainSliderClasses = {
    slideArrowController:   SlideArrowController, 
    SlideContentController: SlideContentController,
    slideItem:              SlideItem, 
    slider:                 Slider,
    sliderFacade:           SliderFacade,
};

export default mainSliderClasses;