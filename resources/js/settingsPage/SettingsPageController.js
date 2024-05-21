import SettingsPageSidebar from "./SettingsPageSidebar";

class SettingsPageController {
    #settingsPageSidebar = null;
    
    init(settingsPageSidebar) {
        this.#settingsPageSidebar = new settingsPageSidebar;
        this.#settingsPageSidebar.init();

        this.checkOpenModalWindow();
    }

    checkOpenModalWindow() {
        //пытаюсь решить в этом методе проблему с поломкой скриптов после открытия модальных окон
        const body = document.querySelector('body');
        const self = this;

        const observer = new MutationObserver((mutations) => {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === 'class') {
                    self.#settingsPageSidebar.init();
                }
            });
        });
        
        const config = { attributes: true };

        observer.observe(body, config);
    }
}

const settingsPageController = new SettingsPageController;
settingsPageController.init(SettingsPageSidebar);