document.addEventListener("DOMContentLoaded", function(event) {
    const sliderHeader = document.getElementById('slider-header');
    if (sliderHeader && sliderHeader.childElementCount > 1) {
        tns({
            container: '#slider-header',
            slideBy: 'page',
            autoplay: false,
            controlsPosition: 'bottom',
            lazyLoad: true,
            nav: false,
            autoWidth: true,
            controlsContainer: "#slider-header-controls"
        });
    }
});