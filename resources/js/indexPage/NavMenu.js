class NavMenu {
    #navMenu = null;
    #navMenuHeight = null;
    #stickyMenuClass = 'nav-menu-sticky';
    #deltaForAppearance = 200;
    
    init() {
        this.#navMenu = document.body.querySelector('.nav-menu');
        this.#navMenuHeight = parseInt(window.getComputedStyle(this.#navMenu).height);
        this.#deltaForAppearance = Math.floor(window.innerHeight / 2);

        window.addEventListener('scroll', () => {
            const posTop = window.pageYOffset;

            if ((posTop > this.#navMenuHeight + this.#deltaForAppearance) && !this.#navMenu.classList.contains(this.#stickyMenuClass)) {
                this.addClass();
            }

            if ((posTop < this.#navMenuHeight + this.#deltaForAppearance) && this.#navMenu.classList.contains(this.#stickyMenuClass)) {
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