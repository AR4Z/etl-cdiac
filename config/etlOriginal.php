<?php

return [

    'meteorologica' => [

        'typeProcess'           => 'Original',
        'tableSpaceWork'        => 'temporal_weather',
        'repositorySpaceWork'   => 'Facades\\App\\Repositories\\TemporaryWork\\TemporalWeatherRepository',
        'tableDestination'      => 'Originales',

    ],

    'hidrometeorologica' => [

        'typeProcess' => 'Original',
        'tableSpaceWork' => 'temporal_weather',
        'repositorySpaceWork'   => 'Facades\\App\\Repositories\\TemporaryWork\\TemporalWeatherRepository',
        'tableDestination' => 'Originales',

    ],

    'solo_precipitacion' => [

        'typeProcess' => 'Original',
        'tableSpaceWork' => 'temporal_weather',
        'repositorySpaceWork'   => 'Facades\\App\\Repositories\\TemporaryWork\\TemporalWeatherRepository',
        'tableDestination' => 'Originales',

    ],

    'calidad_del_aire' => [

        'typeProcess'           => 'Original',
        'tableSpaceWork'        => 'temporal_weather',
        'repositorySpaceWork'   => 'Facades\\App\\Repositories\\TemporaryWork\\TemporalAirRepository',
        'tableDestination'      => 'Originales_aire',
    ],

];