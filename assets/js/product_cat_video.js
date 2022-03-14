(() => {
    const $ = jQuery;
    const videos = $('video');
    const videoContainer = $('.video');
    const isPlayingCls = 'playing';

    videoContainer.each((video, b) => {
        console.log(video);
        console.log(b);
        const button = document.createElement("button");
        button.classList.add('video-button');
        button.onclick = (e) => {
            if (button.classList.contains(isPlayingCls)) {
                pauseVideo(button);
            } else {
                playVideo(button);
            }
        }

        $(video).parents('li').append(button);
    });

    // Desktop
    videoContainer.hover(function() {
        playVideo(this)
    }, function () {
        pauseVideo(this)
    });

    const playVideo = (el) => {
        console.log(el);
        var $button = $(el);
        $button.parent('li').find('video').get(0).play();
        $button.addClass(isPlayingCls);
    }

    const pauseVideo = (el) => {
        console.log(el);
        var $button = $(el);
        $button.parent('li').find('video').get(0).pause();
        $button.removeClass(isPlayingCls);
    }
})()