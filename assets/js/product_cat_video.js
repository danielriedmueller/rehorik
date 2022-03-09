(function () {
    var $ = jQuery;
    var videos = $('video');
    var buttons = $('.video button');
    var videoContainer = $('.video');
    var isPlayingCls = 'playing';

    // Desktop
    videoContainer.hover(function() {
        playVideo(this)
    }, function () {
        pauseVideo(this)
    });

    // Mobile
    videoContainer.waypoint({
        handler: function() {
            playVideo(this.element);
        },
        offset: '30%'
    })

    function playVideo(el) {
        pauseAllVideos();
        var video = $(el).children('video');
        var button = $(el).children('button');
        video.get(0).play();
        button.addClass(isPlayingCls);
    }

    function pauseVideo(el) {
        var video = $(el).children('video');
        var button = $(el).children('button');
        video.get(0).pause();
        button.removeClass(isPlayingCls);
    }

    function pauseAllVideos() {
        videos.each(function () {
            $(this).get(0).pause();
        })
        buttons.removeClass(isPlayingCls);
    }
})()