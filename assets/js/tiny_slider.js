document.addEventListener("DOMContentLoaded", function(event) {
    const slider = document.getElementById('slider');
    if (slider && slider.childElementCount > 1) {
        tns({
            container: '#slider',
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