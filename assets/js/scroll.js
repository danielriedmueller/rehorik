(function () {
    const elements = document.querySelectorAll('[data-scrollpos]');
    const scrollPosThreshold = 187;

    window.onscroll = function () {
        const currentScrollPos = window.pageYOffset;
        if (currentScrollPos > scrollPosThreshold) {
            elements.forEach(function (el) {
                el.classList.add("scrolled");
            })
        } else {
            elements.forEach(function (el) {
                el.classList.remove("scrolled");
            })
        }

        elements.forEach(function (el) {
            el.dataset.ypos = currentScrollPos > scrollPosThreshold ? 100 : Math.floor((currentScrollPos / scrollPosThreshold) * 100);
        })
    }
})();
