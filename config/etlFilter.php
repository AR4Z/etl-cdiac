<?php


return [

    'meteorologica' => [

        'typeProcess'           => 'Filter',
        'tableSpaceWork'        => 'temporal_weather',
        'repositorySpaceWork'   => 'Facades\\App\\Repositories\\TemporaryWork\\TemporalWeatherRepository',
        'repositoryDestination' => 'Facades\\App\\Repositories\\DataWareHouse\\FactTableRepository',
        'tableDestination'      => 'fact_table',
        'stateTable'            => 'filterState',

    ],

    'hidrometeorologica' => [

        'typeProcess'           => 'Filter',
        'tableSpaceWork'        => 'temporal_weather',
        'repositorySpaceWork'   => 'Facades\\App\\Repositories\\TemporaryWork\\TemporalWeatherRepository',
        'repositoryDestination' => 'Facades\\App\\Repositories\\DataWareHouse\\FactTableRepository',
        'tableDestination'      => 'fact_table',
        'stateTable'            => 'filterState',

    ],

    'solo_precipitacion' => [

        'typeProcess'           => 'Filter',
        'tableSpaceWork'        => 'temporal_weather',
        'repositorySpaceWork'   => 'Facades\\App\\Repositories\\TemporaryWork\\TemporalWeatherRepository',
        'repositoryDestination' => 'Facades\\App\\Repositories\\DataWareHouse\\FactTableRepository',
        'tableDestination'      => 'fact_table',
        'stateTable'            => 'filterState',

    ],

    'calidad_del_aire' => [

        'typeProcess'           => 'Filter',
        'tableSpaceWork'        => 'temporal_weather',
        'repositorySpaceWork'   => 'Facades\\App\\Repositories\\TemporaryWork\\TemporalAirRepository',
        'repositoryDestination' => 'Facades\\App\\Repositories\\DataWareHouse\\FactAirRepository',
        'tableDestination'      => 'fact_aire',
        'stateTable'            => 'filterState',

    ],

];