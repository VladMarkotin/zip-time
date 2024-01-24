class PageSmoothAppear {

    static init() {
        const mainPreloader = document.getElementById('main_preloader_wrapper');
        mainPreloader.remove();    
        
        window.addEventListener('load', () => {
            document.getElementById('app').style.opacity = 1;
        });
    }
}

PageSmoothAppear.init();