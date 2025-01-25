<?php

if (!defined('ABSPATH')) {
    die('-1');
}

/*
 * Transforms YouTube Video
 */
class Reh_Page_Video_Helper
{
    public static function sanitizeVideo(string $video): string
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

    public static function isLocalVideo($path): bool
    {
        $videoExtensions = ['mp4', 'avi', 'mov', 'wmv', 'flv', 'mkv', 'webm'];

        // Extract the file extension from the string
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if (in_array($extension, $videoExtensions)) {
            return true;
        }

        return false;
    }
}
