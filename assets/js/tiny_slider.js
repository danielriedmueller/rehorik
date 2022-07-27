document.addEventListener("DOMContentLoaded", function(event) {
    const slider = document.getElementById('slider-content');
    if (slider && slider.childElementCount > 1) {
        tns({
            container: '#slider-content',
            slideBy: 'page',
            autoplay: false,
            controlsPosition: 'bottom',
            lazyLoad: true,
            nav: false,
            autoWidth: true,
            controlsContainer: "#tns-controls-container"
        });
    }
});
