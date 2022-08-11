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

    const sliderBody = document.getElementById('slider-body');
    if (sliderBody && sliderBody.childElementCount > 1) {
        tns({
            container: '#slider-body',
            items: 1,
            gutter: 50,
            responsive: {
                1300: {
                    items: 2
                }
            },
            nav: false,
            controlsPosition: 'bottom',
            controlsContainer: "#slider-body-controls"
        });
    }
});