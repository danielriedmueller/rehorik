(function () {
    // Mobile menu breakpoint. Used also in css.
    const mobileMenuBreakpoint = 1180;
    const screenWidth = window.innerWidth;
    if (screenWidth > mobileMenuBreakpoint) return;

    const clickEvent = 'ontouchstart' in document.documentElement ? 'touchstart' : 'click';

    window.addEventListener('DOMContentLoaded', (event) => {
        const menuItems = document.querySelectorAll('.menu-item-has-children > a');
        const openCls = 'open';
        menuItems.forEach((item) => {
            item.addEventListener(clickEvent, (e) => {
                e.preventDefault();
                e.stopPropagation();
                item.classList.toggle(openCls);
            });
        });

        // Prevent scrolling when mobile menu is open
        document.getElementById('burger-button').addEventListener('change', (event) => {
            if (event.currentTarget.checked) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = 'scroll';
            }
        })
    });
})();
