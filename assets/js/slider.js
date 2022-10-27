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
            gutter: 0,
            autoWidth: true,
            controlsContainer: "#slider-header-controls"
        });
    }

    const sliderBody = document.getElementById('slider-body');
    if (sliderBody && sliderBody.childElementCount > 1) {
        tns({
            container: '#slider-body',
            items: 1,
            lazyLoad: true,
            gutter: 0,
            responsive: {
                898: {
                    items: 2,
                    gutter: 50,
                }
            },
            nav: false,
            controlsPosition: 'bottom',
            controlsContainer: "#slider-body-controls"
        });
    }
});