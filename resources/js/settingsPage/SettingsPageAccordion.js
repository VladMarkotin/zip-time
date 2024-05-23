class SettingsPageAccordion {
    #accordionHeads  = [];
    #accordionBodies = [];
    #accrodionHeadActiveClass = 'accordion-head-active';
    #localStorageKey          = 'activeAccodrionId'
    
    init() {
        this.#accordionHeads  = document.querySelectorAll('.saved-tasks-table-body .accordion-head');
        this.#accordionBodies = document.querySelectorAll('.saved-tasks-table-body .accordion-body');

        const savedId = localStorage.getItem(this.#localStorageKey);

        if (savedId) {
            const id = JSON.parse(savedId);
            
            const heads = this.#accordionHeads;

            for (let i = 0; i < heads.length; i++) {
                if (heads[i].dataset.id === id) {
                    heads[i].classList.add(this.#accrodionHeadActiveClass);
                    break;
                }
            }
        }

        this.addClickHandler();

        function beforeUnloadHandler() {
            localStorage.removeItem(this.#localStorageKey);
        }

        window.addEventListener('beforeunload', beforeUnloadHandler.bind(this));
    }

    addClickHandler() {
        this.#accordionHeads.forEach(item => {
            item.onclick= (e) => {
                this.#accordionHeads.forEach(item => {
                    if (item === e.target) {
                        const {id} = e.target.dataset;
                        this.saveId(id);

                        item.classList.toggle(this.#accrodionHeadActiveClass)
                    }
                    else item.classList.remove(this.#accrodionHeadActiveClass)
                })
            };
        })
    }

    saveId(id) {
        localStorage.setItem(this.#localStorageKey, JSON.stringify(id));
    }
}

export default SettingsPageAccordion