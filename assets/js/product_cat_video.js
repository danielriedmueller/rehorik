document.addEventListener('DOMContentLoaded', () => {
    const isPlayingCls = 'playing';

    Array.from(document.getElementsByTagName('video')).forEach(video => {
        const link = video.parentElement;
        const cat = link.parentElement;

        const button = document.createElement("button");
        button.classList.add('video-button');

        if (isTouchDevice()) {
            button.onclick = () => {
                if (button.classList.contains(isPlayingCls)) {
                    toggleVideo(video, button, false);
                } else {
                    toggleVideo(video, button);
                }
            }
        } else {
            button.style.pointerEvents = "none";
            cat.onmouseenter = () => toggleVideo(video, button);
            cat.onmouseleave = () => toggleVideo(video, button, false);
        }

        cat.insertBefore(button, link);
    })

    const toggleVideo = (video, button, play = true) => {
        if (play) {
            video.play();
            button.classList.add(isPlayingCls);
        } else {
            video.pause();
            button.classList.remove(isPlayingCls);
        }
    }

    function isTouchDevice() {
        return (('ontouchstart' in window) ||
            (navigator.maxTouchPoints > 0) ||
            (navigator.msMaxTouchPoints > 0));
    }
});