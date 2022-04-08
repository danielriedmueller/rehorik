document.addEventListener("DOMContentLoaded", function(event) {
    if (document.getElementById('slider')) {
        tns({
            container: '#slider',
            slideBy: 'page',
            autoplay: false,
            controlsPosition: 'bottom',
            nav: false,
            autoWidth: true,
            controlsContainer: "#tns-controls-container"
        });
    }
});