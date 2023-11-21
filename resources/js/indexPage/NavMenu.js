class NavMenu {
    #navMenu = null;
    #navMenuHeight = null;
    #stickyMenuClass = 'nav-menu-sticky';
    
    init() {
        this.#navMenu = document.body.querySelector('.nav-menu');
        this.#navMenuHeight = parseInt(window.getComputedStyle(this.#navMenu).height);

        window.addEventListener('scroll', () => {
            const posTop = window.pageYOffset;

            if ((posTop > this.#navMenuHeight + 150) && !this.#navMenu.classList.contains(this.#stickyMenuClass)) {
                this.addClass();
            }

            if ((posTop < this.#navMenuHeight + 150) && this.#navMenu.classList.contains(this.#stickyMenuClass)) {
                this.removeClass();
            }
        })
    }

    addClass() {
        this.#navMenu.classList.add(this.#stickyMenuClass);
    }

    removeClass() {
        this.#navMenu.classList.remove(this.#stickyMenuClass);
    }
}

const navMenu = new NavMenu;
navMenu.init();