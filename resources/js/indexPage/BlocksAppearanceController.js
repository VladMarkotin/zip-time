class BlocksAppearanceController {
    #animatedElements   = null;
    #ourAdvantagesItems = null;
    #ourAdvantagesTimer = null;
    #statisticsItems    = null;
    #statisticsTimer    = null;
    #statisticsCounter  = null

    constructor(statisticsCounter) {
        this.#statisticsCounter = statisticsCounter;
    }

    init() {
        this.#animatedElements = document.querySelectorAll('.element-animation');
        this.#ourAdvantagesItems = document.querySelectorAll('.our-advantages-item');
        this.#statisticsItems = document.querySelectorAll('.statistics-item');
        if (this.#ourAdvantagesItems.length) this.#ourAdvantagesTimer = getTimer(this.#ourAdvantagesItems, 200);
        if (this.#statisticsItems.length) this.#statisticsTimer = getTimer(this.#statisticsItems, 150);

        const options = {
            threshold: [0.4],
        }

        const observer = new IntersectionObserver((entry) => {
            entry.forEach(change => {
                const curentElement = change.target;

                if (change.isIntersecting && !curentElement.classList.contains('element-show')) {
                    const isOuAdvItem = curentElement.classList.contains('our-advantages-item');
                    const isStatisticItem = curentElement.classList.contains('statistics-item');

                    switch (true) {
                        case isOuAdvItem:
                            this.showList(change, this.#ourAdvantagesTimer);
                        break;
                        case isStatisticItem:
                            this.showList(change, this.#statisticsTimer);
                        break
                        default:
                            this.addElemShowClass(change);
                    }
                }
            })
        }, options)

        if (this.#animatedElements.length) {
            for (const item of this.#animatedElements) {
                observer.observe(item);
            }
        }

        function* getTimer(items, interval = 300) {
            for (let i = 1; i <= items.length; i++) yield i * interval;
        }
        
    }

    addElemShowClass(elem) {
        elem = elem.target;
        elem.classList.add('element-show');
        if (elem.classList.contains('statistics-item')) this.createStatisticsCounter(elem);
    }

    showList(change, generator) {
        let time = null;
        try {
            time = generator.next().value;
        } catch(e) {
            console.error(e);
        }
        
        setTimeout(() => {
            this.addElemShowClass(change);
        }, time ? time : 0);
    }

    createStatisticsCounter(elem) {
        const statisticsCounter = new this.#statisticsCounter(elem);
        statisticsCounter.init();
    }
}

export default BlocksAppearanceController;