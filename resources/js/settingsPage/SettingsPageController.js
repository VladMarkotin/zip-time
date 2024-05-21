import SettingsPageSidebar from "./SettingsPageSidebar";

class SettingsPageController {
    #settingsPageSidebar = null;
    
    init(settingsPageSidebar) {
        this.#settingsPageSidebar = new settingsPageSidebar();
        this.#settingsPageSidebar.init();

        const self = this;
        
        window.livewire.on('rerender', () => {
            self.#settingsPageSidebar.init();
        });
    }
}

const settingsPageController = new SettingsPageController;
settingsPageController.init(SettingsPageSidebar);