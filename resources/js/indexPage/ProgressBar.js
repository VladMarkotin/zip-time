class ProgressBar {
    #progressBar         = null;
    #minHeigt            = 3500;
    #isProgressBarExists = null;
    #windowHeight        = null;
    #app                 = null;

    init() {
        this.#progressBar = document.createElement('div');
        this.#progressBar.classList.add('progress-bar');
        this.#app = document.getElementById('app');

        this.#isProgressBarExists = !!this.findProgressBar();
        this.calPercents = this.calPercents.bind(this);
        
        this.#windowHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;

        if (!this.#isProgressBarExists && (this.#windowHeight >= this.#minHeigt)) this.#app.prepend(this.#progressBar);
        
        if (this.#windowHeight >= this.#minHeigt) {
            this.calPercents();
            if (!window.onscroll) window.onscroll = this.calPercents;
        }
        
        if (this.#isProgressBarExists && this.#windowHeight < this.#minHeigt) {
            this.findProgressBar().remove();
            window.onscroll = null;
        }
    }

    updateWidth(per) {
        this.findProgressBar().style.width = `${per}%`;
    }

    calPercents(e) {
        const windowScroll = document.body.scrollTop;
        const per = windowScroll / this.#windowHeight * 100;
    
        this.updateWidth(per);
    }

    findProgressBar() {
        return this.#app.querySelector('.progress-bar');
    }
}

export default ProgressBar