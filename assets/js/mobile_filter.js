(function () {
    // Mobile menu breakpoint. Used also in css.
    const mobileMenuBreakpoint = 1180;
    if (!window.matchMedia(`(max-width: ${mobileMenuBreakpoint}px)`).matches) return;

    window.addEventListener('DOMContentLoaded', (event) => {
        // Mobile product filter button
        const sidebar = document.getElementById('sidebar');
        const showCls = 'show';

        const showFilter = () => {
            sidebar.classList.add(showCls);
            document.body.style.overflow = 'hidden';
        }

        const hideFilter = () => {
            sidebar.classList.remove(showCls);
            document.body.style.overflow = 'scroll';
        }

        const productFilterButton = document.getElementById('product-filter-button');
        const productFilterCloseButton = document.getElementById('product-filter-close-button');

        if (productFilterButton) {
            productFilterButton.addEventListener('click', (event) => {
                sidebar.classList.contains(showCls) ? hideFilter() : showFilter();
            });
        }

        if (productFilterCloseButton) {
            productFilterCloseButton.addEventListener('click', hideFilter);
        }
    });
})();
