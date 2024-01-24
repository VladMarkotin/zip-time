class PageSmoothAppear {
    static init() {
        window.addEventListener('load', () => {
            document.body.style.opacity = 1;
        });
    }
}

PageSmoothAppear.init();