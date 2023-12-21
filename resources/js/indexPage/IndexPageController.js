import BlocksAppearanceController from "./BlocksAppearanceController";
import OurAdvantagesController from "./OurAdvantages";
import PhilosofySlider from "./PhilosofySlider";
import mainSliderClasses from "./Slider";
import StatisticsCounter from "./StatisticsCounter";
import ProgressBar from "./ProgressBar";

class IndexPageController {
    #blocksAppearanceController = null;
    #ourAdvantagesController    = null;
    #philosofySlider            = null;

    #slideArrowController       = null;
    #slideItem                  = null;
    #slider                     = null;
    #sliderFacade               = null;
    #slideContentController     = null;

    #statisticsCounter          = null;
    #progressBar                = null;

    init(blocksAppearanceController, ourAdvantagesController, philosofySlider, slideArrowController, slideItem, slider, sliderFacade, slideContentController, statisticsCounter, progressBar) {
        this.#statisticsCounter = statisticsCounter;
        this.#blocksAppearanceController = new blocksAppearanceController(this.#statisticsCounter);
        this.#ourAdvantagesController = new ourAdvantagesController;
        this.#philosofySlider = new philosofySlider;
        this.#progressBar   = new progressBar;

        this.#slideArrowController = new slideArrowController;
        this.#slideItem = slideItem;
        this.#slider    = slider;
        this.#slideContentController = slideContentController;
        this.#sliderFacade = new sliderFacade(new this.#slider, this.#slideItem, this.#slideContentController);

        this.#blocksAppearanceController.init();
        this.#ourAdvantagesController.init();
        this.#philosofySlider.init();
        this.#slideArrowController.init();
        this.#sliderFacade.init();
        this.#progressBar.init();

        window.addEventListener('resize', () => {
            this.#philosofySlider.init();
            this.#philosofySlider.move(this.#philosofySlider.currentSlideIndex);
            
            this.#sliderFacade.init();
            
            this.#progressBar.init();
        });
    }
}

const indexPageController = new IndexPageController;

const {slideArrowController, slider, slideItem, sliderFacade, SlideContentController} = mainSliderClasses;

indexPageController.init(BlocksAppearanceController, OurAdvantagesController, PhilosofySlider, slideArrowController, slideItem, slider, sliderFacade, SlideContentController, StatisticsCounter, ProgressBar);