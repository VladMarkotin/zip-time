import BlocksAppearanceController from "./BlocksAppearanceController";
import OurAdvantagesController from "./OurAdvantages";
import ReviewsSlider from "./ReviewsSlider";
import mainSliderClasses from "./Slider";

class IndexPageController {
    #blocksAppearanceController = null;
    #ourAdvantagesController    = null;
    #reviewsSlider              = null;

    #slideArrowController       = null;
    #slideItem                  = null;
    #slider                     = null;
    #sliderFacade               = null;
    #slideContentController     = null;

    init(blocksAppearanceController, ourAdvantagesController, reviewsSlider, slideArrowController, slideItem, slider, sliderFacade, slideContentController) {
        this.#blocksAppearanceController = new blocksAppearanceController;
        this.#ourAdvantagesController = new ourAdvantagesController;
        this.#reviewsSlider = new reviewsSlider;

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

        window.addEventListener('resize', () => {
            this.#reviewsSlider.init();
            this.#reviewsSlider.move(this.#reviewsSlider.currentSlideIndex);

            this.#sliderFacade.init();
        });
    }
}

const indexPageController = new IndexPageController;

const {slideArrowController, slider, slideItem, sliderFacade, SlideContentController} = mainSliderClasses;

indexPageController.init(BlocksAppearanceController, OurAdvantagesController, ReviewsSlider, slideArrowController, slideItem, slider, sliderFacade, SlideContentController);