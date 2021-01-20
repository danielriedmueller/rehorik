(function () {
    var socialMediaIcons = document.getElementById("rehorik-social-media-icons");
    var prevScrollpos = window.pageYOffset;

    window.onscroll = function() {
        var currentScrollPos = window.pageYOffset;
        if (prevScrollpos > currentScrollPos) {
            socialMediaIcons.classList.remove("visible");
            socialMediaIcons.classList.add("hidden");
        } else {
            socialMediaIcons.classList.remove("hidden");
            socialMediaIcons.classList.add("visible");
        }
        prevScrollpos = currentScrollPos;
    }
})()