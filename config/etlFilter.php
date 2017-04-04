<?php


return [

    'meteorologica' => [

        'typeProcess' => 'Filter',
        'tableSpaceWork' => 'temporal_weather',
        'repositorySpaceWork'   => 'Facades\\App\\Repositories\\TemporaryWork\\TemporalWeatherRepository',
         'tableDestination' => 'fact_table',

    ],

    'hidrometeorologica' => [

        'typeProcess' => 'Filter',
        'tableSpaceWork' => 'temporal_weather',
        'repositorySpaceWork'   => 'Facades\\App\\Repositories\\TemporaryWork\\TemporalWeatherRepository',
        'tableDestination' => 'fact_table',

    ],

    'solo_precipitacion' => [

        'typeProcess' => 'Filter',
        'tableSpaceWork' => 'temporal_weather',
        'repositorySpaceWork'   => 'Facades\\App\\Repositories\\TemporaryWork\\TemporalWeatherRepository',
        'tableDestination' => 'fact_table',

    ],

    'calidad_del_aire' => [

        'typeProcess' => 'Filter',
        'tableSpaceWork' => 'temporal_weather',
        'repositorySpaceWork'   => 'Facades\\App\\Repositories\\TemporaryWork\\TemporalAirRepository',
        'tableDestination'      => 'fact_aire',

    ],

];