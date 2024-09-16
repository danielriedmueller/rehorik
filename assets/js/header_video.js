document.addEventListener('DOMContentLoaded', () => {
    const mobileBreakpoint = 767;
    let isMobile = true;
    if (window.matchMedia(`(min-width: ${mobileBreakpoint + 1}px)`).matches) {
        isMobile = false;
    }

    Array.from(document.getElementsByTagName('video')).forEach(video => {
        let large = video.attributes['data-large'];
        let small = video.attributes['data-small'];

        if (!large || !small) {
            console.error('No video sources found');
            return;
        }

        large = large.value;
        small = small.value;

        if (large.length === 0 || small.length === 0) {
            console.error('No video sources found');
            return;
        }

        if (isMobile) {
            video.src = small;
        } else {
            video.src = large;
        }
    })
});