class SettingsPageAccordion {
    #accordionHeads  = [];
    #accordionBodies = [];
    #accrodionHeadActiveClass = 'accordion-head-active';
    
    init() {
        this.#accordionHeads  = document.querySelectorAll('.saved-tasks-table-body .accordion-head');
        this.#accordionBodies = document.querySelectorAll('.saved-tasks-table-body .accordion-body');

        this.#accordionHeads.forEach(item => {
            item.onclick= (e) => {
                this.#accordionHeads.forEach(item => {
                    if (item === e.target) item.classList.toggle(this.#accrodionHeadActiveClass);
                    else item.classList.remove(this.#accrodionHeadActiveClass)
                })
            };
        })
    }
}

export default SettingsPageAccordion