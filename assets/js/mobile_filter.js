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

        document.getElementById('product-filter-button').addEventListener('click', (event) => {
            sidebar.classList.contains(showCls) ? hideFilter() : showFilter();
        });
        document.getElementById('product-filter-close-button').addEventListener('click', (event) => hideFilter());
    });
})();
