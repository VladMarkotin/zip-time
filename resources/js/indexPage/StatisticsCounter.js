class StatisticsCounter {
    #statisticsCounterBlock = null;
    #time                   = 1500;
    #step                   = null;
    #stepInitialVal         = 1;
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
        this.#step = this.getStep(this.#stepInitialVal);

        let n = this.#statisticsCounterMin;
        const t = Math.round(this.#time / (this.#statisticsCounterMax / this.#step));
        const interval = setInterval(() => {
            n = n + this.#step;
            if (n >= this.#statisticsCounterMax) {
                clearInterval(interval);
                this.#statisticsCounter.innerHTML = this.#statisticsCounterMax;
            } else {
                this.#statisticsCounter.innerHTML = n;
            }
        }, t);
    }

    isNaNCheck(value) {
        return !Number.isNaN(value) && typeof value === 'number' ? value : 0;
    }

    getStep(val) {
        const t = Math.round(this.#time / (this.#statisticsCounterMax / val));

        if (t < (this.#time / 30)) {
            val++
            return this.getStep(val);
        }

        if (t > this.#time) {
            val--
            return this.getStep(val);
        }

        return val;
    }
}

export default StatisticsCounter