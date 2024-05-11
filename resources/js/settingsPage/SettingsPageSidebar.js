class SettingsPageSidebar {
    #settingsTableTabs            = null;
    #settingsSidebarBtn           = null;
    #settingsTableTabsMobileClass = 'sidebar-mobile' 
    #settingsSidebarBtnVisClass   = 'settings-sidebar-btn-visible'

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
            }
        } else {
            this.#settingsTableTabs  && this.#settingsTableTabs.classList.remove(this.#settingsTableTabsMobileClass);
            this.#settingsSidebarBtn && this.#settingsSidebarBtn.classList.remove(this.#settingsSidebarBtnVisClass);
        }
    }

    sideBarMobileActivateHandl() {
        
    }
}

const settingsPageSidebar = new SettingsPageSidebar;
settingsPageSidebar.init();