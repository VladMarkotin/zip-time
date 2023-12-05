class StatisticsCounter {
    #statisticsCounterBlock = null;
    #time                   = 1200;
    #step                   = 1;
    #statisticsCounter      = null;
    #statisticsCounterMin   = null;
    #statisticsCounterMax   = null;

    constructor(elem) {
        this.#statisticsCounterBlock = elem;
    }

    init() {
        this.#statisticsCounter = this.#statisticsCounterBlock.querySelector('.statistics-counter');
        const statCounterMinVal = +this.#statisticsCounter.innerHTML;
        const statCounterMaxVal = +this.#statisticsCounter.dataset.counterval;
        this.#statisticsCounterMin = this.isNaNCheck(statCounterMinVal);
        this.#statisticsCounterMax = this.isNaNCheck(statCounterMaxVal);
        
        let n = this.#statisticsCounterMin;
        const t = Math.round(this.#time / (this.#statisticsCounterMax / this.#step));
        const interval = setInterval(() => {
            n = n + this.#step;
            if (n === this.#statisticsCounterMax) clearInterval(interval);
            this.#statisticsCounter.innerHTML = n;
        }, t);
    }

    isNaNCheck(value) {
        return !Number.isNaN(value) ? value : 0;
    }
}

export default StatisticsCounter