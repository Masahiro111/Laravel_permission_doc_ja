<?php

return [
    'production' => false,
    'baseUrl' => '/public',
    'title' => 'Jigsaw',
    'description' => 'Website description.',
    'collections' => [
        'posts' => [
            'path' => 'blog/{date|Y-m-d}/{filename}',
        ],
    ],
    'build' => [
        'destination' => 'public',
    ],
];
