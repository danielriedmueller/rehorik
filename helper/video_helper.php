<?php

/*
 * Transforms YouTube Video
 */
function validateVideo($video)
{
    /*
     * from: https://www.youtube.com/watch?v=RdGTPwIeOu8
     * to: https://www.youtube.com/embed/RdGTPwIeOu8
     */
    if (str_contains($video, 'youtube.com/watch?v=') && !str_contains($video, 'embed')) {
        $video = str_replace('watch?v=', 'embed/', $video);
    }

    /*
     * from: https://youtu.be/9-GorMgKIFA
     * to: https://www.youtube.com/embed/9-GorMgKIFA
     */
    if (str_contains($video, 'youtu.be/') && !str_contains($video, 'embed')) {
        $video = str_replace('youtu.be/', 'youtube.com/embed/', $video);
    }

    return $video;
}
