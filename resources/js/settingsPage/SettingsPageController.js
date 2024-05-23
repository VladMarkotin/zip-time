import SettingsPageSidebar from "./SettingsPageSidebar";
import SettingsPageAccordion from "./SettingsPageAccordion";

class SettingsPageController {
    #settingsPageSidebar   = null;
    #settingsPageAccordion = null;
    
    init(settingsPageSidebar, settingsPageAccordion) {
        this.#settingsPageSidebar = new settingsPageSidebar();
        this.#settingsPageAccordion = new settingsPageAccordion();

        this.#settingsPageSidebar.init();
        this.#settingsPageAccordion.init();

        const self = this;
        
        window.livewire.on('rerender', () => {
            self.#settingsPageSidebar.init();
            self.#settingsPageAccordion.init();
        });
    }
}

const settingsPageController = new SettingsPageController;
settingsPageController.init(SettingsPageSidebar, SettingsPageAccordion);