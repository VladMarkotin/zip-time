const slides = document.body.querySelectorAll('.slide');
const slider = new Array;
const sliderWrapper = document.querySelector('.slider-wrapper');
const currentWidth = window.innerWidth;
const sliderLeftArrow = document.querySelector('.slider-left-arrow-wrapper');
const sliderRightArrow = document.querySelector('.slider-right-arrow-wrapper');

for (let item of slides) {
    slider.push(item.classList.value.split(' '));
    item.remove();
}

let step   = 0;
let offset = 0;

const draw = () => {
    const slide = document.createElement('div');

    for(let item of slider[step]) {
        slide.classList.add(item);
    }
    
    slide.style.left = offset * currentWidth + 'px';
    sliderWrapper.appendChild(slide);

    if (step + 1 === slider.length) {
        step = 0;
    } else {
        step++;
    }
    offset = 1;
}

const right = () => {
    const slides = document.querySelectorAll('.slide');
    let offset = 0;
    
    for (let item of slides) {
        item.style.left = offset * currentWidth - currentWidth + 'px';
        offset++;
    }

    setTimeout(() => {
        slides[0].remove();
        draw();
    }, 600);
}

const left = () => {
    sliderLeftArrow.onclick=null;
    const slides = document.querySelectorAll('.slide');
    let offset = 0;

    for (let item of slides) {
        item.style.left = offset * currentWidth - currentWidth + 'px';
        offset++;
    }

    setTimeout(() => {
        slides[0].remove();
        draw();
        sliderLeftArrow.onclick=left;
    }, 600);
}

draw();
draw();

sliderLeftArrow.addEventListener('click', left);
