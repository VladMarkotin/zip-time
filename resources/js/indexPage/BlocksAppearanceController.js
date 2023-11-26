class BlocksAppearanceController {
    #animatedElements = null;

    init() {
        this.#animatedElements = document.querySelectorAll('.element-animation');

        const options = {
            threshold: [0.5],
        }

        const observer = new IntersectionObserver((entry) => {
            entry.forEach(change => {
                if (change.isIntersecting) {
                    change.target.classList.add('element-show');
                    console.log(change.target);
                }
            })
        }, options)
        
        for (const item of this.#animatedElements) {
            observer.observe(item);
        }
    }
}

const blocksAppearanceController = new BlocksAppearanceController;
blocksAppearanceController.init();