class SettingsPageSidebar {
    #settingsTableTabs               = null;
    #settingsSidebarBtn              = null;
    #settingsTableTabsMobileClass    = 'sidebar-mobile' 
    #settingsTableTabsMobileVisClass = 'sidebar-mobile-visible';
    #settingsSidebarBtnVisClass      = 'settings-sidebar-btn-visible'

    init() {
        this.#settingsTableTabs  = document.body.querySelector('.settings-table-tabs-wrapper');
        this.#settingsSidebarBtn = document.body.querySelector('.settings-sidebar-btn');

        window.addEventListener('resize', this.checkWindowWidth.bind(this));
        this.checkWindowWidth();
    }

    checkWindowWidth() {
        if (window.innerWidth <= 1265) {
            this.#settingsTableTabs  && this.#settingsTableTabs.classList.add(this.#settingsTableTabsMobileClass);
            if (this.#settingsSidebarBtn) {
                this.#settingsSidebarBtn.classList.add(this.#settingsSidebarBtnVisClass);
                this.#settingsSidebarBtn.onclick = this.sidebarBtnActivatorHandl.bind(this);
                // document.body.addEventListener('click', this.closeSideBarHandl.bind(this));
            }
        } else {
            this.#settingsSidebarBtn && this.#settingsSidebarBtn.classList.remove(this.#settingsSidebarBtnVisClass);
            if (this.#settingsTableTabs) {
                [this.#settingsTableTabsMobileClass, this.#settingsTableTabsMobileVisClass].forEach(remClass => {
                    this.#settingsTableTabs.classList.remove(remClass);
                })
            }
        }
    }

    sidebarBtnActivatorHandl() {
        this.#settingsTableTabs.classList.add(this.#settingsTableTabsMobileVisClass);
    }

    closeSideBarHandl() {
        console.log('123');
    }
} 

const settingsPageSidebar = new SettingsPageSidebar;
settingsPageSidebar.init();