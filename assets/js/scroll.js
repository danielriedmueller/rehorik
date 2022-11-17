(function () {
    var elements = document.querySelectorAll('[data-scrollpos]');
    var scrollPosThreshold = 187;

    window.onscroll = function() {
        var currentScrollPos = window.pageYOffset;
        if (currentScrollPos > scrollPosThreshold) {
            elements.forEach(function(el) {
                el.classList.add("scrolled");
            })
        } else {
            elements.forEach(function(el) {
                el.classList.remove("scrolled");
            })
        }

        elements.forEach(function(el) {
            el.dataset.ypos  = currentScrollPos > scrollPosThreshold ? 100 : Math.floor((currentScrollPos / scrollPosThreshold) * 100);
        })
    }

    window.addEventListener('DOMContentLoaded', (event) => {
        // Prevent scrolling when mobile menu is open
        document.getElementById('burger-button').addEventListener('change', (event) => {
            if (event.currentTarget.checked) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = 'scroll';
            }
        })
    });
})()
