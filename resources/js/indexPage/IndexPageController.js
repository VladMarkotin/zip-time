import BlocksAppearanceController from "./BlocksAppearanceController";
import OurAdvantagesController from "./OurAdvantages";
import ReviewsSlider from "./ReviewsSlider";
import mainSliderClasses from "./Slider";
import StatisticsCounter from "./StatisticsCounter";
import ProgressBar from "./ProgressBar";

class IndexPageController {
    #blocksAppearanceController = null;
    #ourAdvantagesController    = null;
    #reviewsSlider              = null;

    #slideArrowController       = null;
    #slideItem                  = null;
    #slider                     = null;
    #sliderFacade               = null;
    #slideContentController     = null;

    #statisticsCounter          = null;
    #progressBar                = null;

    init(blocksAppearanceController, ourAdvantagesController, reviewsSlider, slideArrowController, slideItem, slider, sliderFacade, slideContentController, statisticsCounter, progressBar) {
        this.#statisticsCounter = statisticsCounter;
        this.#blocksAppearanceController = new blocksAppearanceController(this.#statisticsCounter);
        this.#ourAdvantagesController = new ourAdvantagesController;
        this.#reviewsSlider = new reviewsSlider;
        this.#progressBar   = new progressBar;

        this.#slideArrowController = new slideArrowController;
        this.#slideItem = slideItem;
        this.#slider    = slider;
        this.#slideContentController = slideContentController;
        this.#sliderFacade = new sliderFacade(new this.#slider, this.#slideItem, this.#slideContentController);

        this.#blocksAppearanceController.init();
        this.#ourAdvantagesController.init();
        this.#reviewsSlider.init();
        this.#slideArrowController.init();
        this.#sliderFacade.init();
        this.#progressBar.init();

        window.addEventListener('resize', () => {
            this.#reviewsSlider.init();
            this.#reviewsSlider.move(this.#reviewsSlider.currentSlideIndex);
            
            this.#sliderFacade.init();
            
            this.#progressBar.init();
        });
    }
}

const indexPageController = new IndexPageController;

const {slideArrowController, slider, slideItem, sliderFacade, SlideContentController} = mainSliderClasses;

indexPageController.init(BlocksAppearanceController, OurAdvantagesController, ReviewsSlider, slideArrowController, slideItem, slider, sliderFacade, SlideContentController, StatisticsCounter, ProgressBar);