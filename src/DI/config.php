<?php

use App\Shortener\Service\UrlConverter;
use App\Shortener\Repository\FileRepository;
use App\Shortener\Helpers\Validation\UrlValidator;

return [
    'services' => [
        'UrlConverter' => function ($container) {
            $validator = $container->get('UrlValidator');
            $fileRepository = $container->get('FileRepository');
            $numberCharCode = 7;
            $codeSalt = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

            $converter = new UrlConverter($validator, $fileRepository, $numberCharCode, $codeSalt);

            return $converter;
        },
        'FileRepository' => function ($container) {
            $fileName = '../file.txt';

            $fileRepository = new FileRepository($fileName);

            return $fileRepository;
        },
        'UrlValidator' => function ($container) {

            $validator = new UrlValidator();

            return $validator;
        }
    ]
];