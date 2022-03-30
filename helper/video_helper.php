<?php

function validateVideo($video)
{
    /*
     * Transforms YouTube Video, eg.:
     *
     * from: https://www.youtube.com/watch?v=RdGTPwIeOu8
     * to: https://www.youtube.com/embed/RdGTPwIeOu8
     */
    if (str_contains($video, 'youtube.com/watch?v=') && !str_contains($video, 'embed')) {
        $video = str_replace('watch?v=', 'embed/', $video);
    }
    return $video;
}
