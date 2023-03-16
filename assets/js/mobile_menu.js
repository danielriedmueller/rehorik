(function () {
    window.addEventListener('DOMContentLoaded', (event) => {
        const menuItems = document.querySelectorAll('.menu-item-has-children > a');
        const openCls = 'open';
        menuItems.forEach((item) => {
            item.addEventListener('click', (e) => {
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
