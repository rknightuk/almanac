<?php

return [

    /** The path to images. If using S3, this will be something like https://yourname.s3.us-east-1.amazonaws.com/ */
    'file_domain' => env('FILE_DOMAIN', '/storage/'),

    /**
     * Want to put images in a specific directory? Put that here.
     * For remote services, include the directory in the domain above
     */
    'storage_path' => env('STORAGE_PATH', 'public'),

    /**
     * API keys for search
     * moviedb does both TV and movies
     */
    'services' => [
        'moviedb' => env('THEMOVIEDB_API_KEY', null),
        'giantbomb' => env('GIANTBOMB_API_KEY', null),
    ],

    /**
     * Metatdata for the site
     */
    'meta' => [
        'site_title' => env('SITE_TITLE', 'Almanac'),
        'site_subtitle' => env('SITE_SUBTITLE', 'by Robb Knight'),
        'external_website' => env('WEBSITE', 'https://rknight.me'),
        'twitter_username' => env('TWITTER', null),
    ]

];
