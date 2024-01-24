class PageSmoothAppear {

    static init() {
        const mainPreloader = document.getElementById('main_preloader_wrapper');
        window.addEventListener('load', () => {
            mainPreloader.remove();    
            document.getElementById('app').style.opacity = 1;
            console.log('страница загрузилась');
        });

    }
}

PageSmoothAppear.init();