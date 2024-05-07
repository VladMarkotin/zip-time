class AsideButtonsController {

    #asideButtonsActivator = null;
    #addLogButton          = null;
    #sendFeedbackButton    = null;
    #asideButtons          = null;
    
    init() {
        this.#asideButtonsActivator = document.querySelector('.aside-buttons-activator-wrapper');
        this.#addLogButton          = document.querySelector('.backlog-add-button');
        this.#sendFeedbackButton    = document.querySelector('.feedback-button');
        this.#asideButtons          = [this.#addLogButton, this.#sendFeedbackButton];

        window.addEventListener('resize', this.checkWindowWidth.bind(this));
        this.checkWindowWidth();
    }

    checkWindowWidth() {
        if (window.innerWidth <= 450) {
            this.#asideButtonsActivator.onclick = this.asideButtonsActivatorHandl.bind(this);

            if (this.#asideButtonsActivator.classList.contains('active')) {
                this.#asideButtonsActivator.classList.remove('active');
            }

        } else {
            this.#asideButtonsActivator.onclick = null;
            this.closeAsideButtons();
        }
    }

    asideButtonsActivatorHandl(e) {
        const isShowAsideButtons = !e.target.classList.contains('active');

        if (isShowAsideButtons) {
            this.#asideButtonsActivator.classList.add('active');  
            
            this.#asideButtons.forEach(button => {
                button && button.classList.add('aside-button-visible');
            })

        } else {
            this.#asideButtonsActivator.classList.remove('active');
            this.closeAsideButtons();
        }
    }

    closeAsideButtons() {
        this.#asideButtons.forEach(button => {
           button && button.classList.remove('aside-button-visible');
        })
    }
}

const asideButtonsController = new AsideButtonsController;
asideButtonsController.init();