<?php


return [

    'meteorologica' => [

        'typeProcess'           => 'Filter',
        'tableSpaceWork'        => 'temporal_weather',
        'tableExist'            => 'exist_fact_table',
        'repositorySpaceWork'   => 'Facades\\App\\Repositories\\TemporaryWork\\TemporalWeatherRepository',
        'repositoryDestination' => 'Facades\\App\\Repositories\\DataWareHouse\\FactTableRepository',
        'repositoryExist'       => 'Facades\\App\\Repositories\\TemporaryWork\\ExistFactTableRepository',
        'tableTrust'            => 'trust_weather',
        'tableDestination'      => 'fact_table',
        'stateTable'            => 'filterState',

    ],

    'hidrometeorologica' => [

        'typeProcess'           => 'Filter',
        'tableSpaceWork'        => 'temporal_weather',
        'tableExist'            => 'exist_fact_table',
        'repositorySpaceWork'   => 'Facades\\App\\Repositories\\TemporaryWork\\TemporalWeatherRepository',
        'repositoryDestination' => 'Facades\\App\\Repositories\\DataWareHouse\\FactTableRepository',
        'repositoryExist'       => 'Facades\\App\\Repositories\\TemporaryWork\\ExistFactTableRepository',
        'tableDestination'      => 'fact_table',
        'tableTrust'            => 'trust_weather',
        'stateTable'            => 'filterState',

    ],

    'solo_precipitacion' => [

        'typeProcess'           => 'Filter',
        'tableSpaceWork'        => 'temporal_weather',
        'tableExist'            => 'exist_fact_table',
        'repositorySpaceWork'   => 'Facades\\App\\Repositories\\TemporaryWork\\TemporalWeatherRepository',
        'repositoryDestination' => 'Facades\\App\\Repositories\\DataWareHouse\\FactTableRepository',
        'repositoryExist'       => 'Facades\\App\\Repositories\\TemporaryWork\\ExistFactTableRepository',
        'tableDestination'      => 'fact_table',
        'tableTrust'            => 'trust_weather',
        'stateTable'            => 'filterState',

    ],

    'calidad_del_aire' => [

        'typeProcess'           => 'Filter',
        'tableSpaceWork'        => 'temporal_air',
        'tableExist'            => 'exist_fact_air',
        'repositorySpaceWork'   => 'Facades\\App\\Repositories\\TemporaryWork\\TemporalAirRepository',
        'repositoryDestination' => 'Facades\\App\\Repositories\\DataWareHouse\\FactAirRepository',
        'repositoryExist'       => 'Facades\\App\\Repositories\\TemporaryWork\\ExistFactAirRepository',
        'tableDestination'      => 'fact_aire',
        'tableTrust'            => 'trust_air',
        'stateTable'            => 'filterState',

    ],

];