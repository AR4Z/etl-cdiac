<?php

return [

    'meteorologica' => [

        'typeProcess'           => 'Original',
        'tableSpaceWork'        => 'temporal_weather',
        'repositorySpaceWork'   => 'Facades\\App\\Repositories\\TemporaryWork\\TemporalWeatherRepository',
        'repositoryDestination' => 'Facades\\App\\Repositories\\DataWareHouse\\OriginalFactTableRepository',
        'tableDestination'      => 'original_fact_table',
        'stateTable'            => 'originalState',

    ],

    'hidrometeorologica' => [

        'typeProcess'           => 'Original',
        'tableSpaceWork'        => 'temporal_weather',
        'repositorySpaceWork'   => 'Facades\\App\\Repositories\\TemporaryWork\\TemporalWeatherRepository',
        'repositoryDestination' => 'Facades\\App\\Repositories\\DataWareHouse\\OriginalFactTableRepository',
        'tableDestination'      => 'original_fact_table',
        'stateTable'            => 'originalState',

    ],

    'solo_precipitacion' => [

        'typeProcess'           => 'Original',
        'tableSpaceWork'        => 'temporal_weather',
        'repositorySpaceWork'   => 'Facades\\App\\Repositories\\TemporaryWork\\TemporalWeatherRepository',
        'repositoryDestination' => 'Facades\\App\\Repositories\\DataWareHouse\\OriginalFactTableRepository',
        'tableDestination'      => 'original_fact_table',
        'stateTable'            => 'originalState',

    ],

    'calidad_del_aire' => [

        'typeProcess'           => 'Original',
        'tableSpaceWork'        => 'temporal_air',
        'repositorySpaceWork'   => 'Facades\\App\\Repositories\\TemporaryWork\\TemporalAirRepository',
        'repositoryDestination' => 'Facades\\App\\Repositories\\DataWareHouse\\OriginalFactAirRepository',
        'tableDestination'      => 'original_fact_aire',
        'stateTable'            => 'originalState',
    ],

];