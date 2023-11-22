class OurAdvantagesController {
    #ourAdvantagesItems     = null
    #ourAdvantagesItemClass = 'our-advantages-item-focus'

    init() {
        this.#ourAdvantagesItems = document.body.querySelectorAll('.our-advantages-item');

        for (const item of this.#ourAdvantagesItems) {
            item.addEventListener('mouseenter', (e) => {
                if (!this.checkClass(e.target)) e.target.classList.add(this.#ourAdvantagesItemClass);
            });

            item.addEventListener('mouseleave', (e) => {
                if (this.checkClass(e.target)) e.target.classList.remove(this.#ourAdvantagesItemClass);
            });
        }
    }

    checkClass(item) {
        return item.classList.contains(this.#ourAdvantagesItemClass)
    }
}

const ourAdvantages = new OurAdvantagesController;
ourAdvantages.init();
