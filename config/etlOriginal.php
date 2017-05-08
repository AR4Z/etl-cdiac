<?php

return [

    'meteorologica' => [

        'typeProcess'           => 'Original',
        'tableSpaceWork'        => 'temporal_weather',
        'tableExist'            => 'exist_fact_table',
        'repositorySpaceWork'   => 'Facades\\App\\Repositories\\TemporaryWork\\TemporalWeatherRepository',
        'repositoryDestination' => 'Facades\\App\\Repositories\\DataWareHouse\\OriginalFactTableRepository',
        'repositoryExist'       => 'Facades\\App\\Repositories\\TemporaryWork\\ExistFactTableRepository',
        'trustRepository'       => 'Facades\\App\\Repositories\\DataWareHouse\\TrustWeatherRepository',
        'tableDestination'      => 'original_fact_table',
        'tableTrust'            => 'trust_weather',
        'stateTable'            => 'originalState',

    ],

    'hidrometeorologica' => [

        'typeProcess'           => 'Original',
        'tableSpaceWork'        => 'temporal_weather',
        'tableExist'            => 'exist_fact_table',
        'repositorySpaceWork'   => 'Facades\\App\\Repositories\\TemporaryWork\\TemporalWeatherRepository',
        'repositoryDestination' => 'Facades\\App\\Repositories\\DataWareHouse\\OriginalFactTableRepository',
        'repositoryExist'       => 'Facades\\App\\Repositories\\TemporaryWork\\ExistFactTableRepository',
        'trustRepository'       => 'Facades\\App\\Repositories\\DataWareHouse\\TrustWeatherRepository',
        'tableDestination'      => 'original_fact_table',
        'tableTrust'            => 'trust_weather',
        'stateTable'            => 'originalState',

    ],

    'solo_precipitacion' => [

        'typeProcess'           => 'Original',
        'tableSpaceWork'        => 'temporal_weather',
        'tableExist'            => 'exist_fact_table',
        'repositorySpaceWork'   => 'Facades\\App\\Repositories\\TemporaryWork\\TemporalWeatherRepository',
        'repositoryDestination' => 'Facades\\App\\Repositories\\DataWareHouse\\OriginalFactTableRepository',
        'repositoryExist'       => 'Facades\\App\\Repositories\\TemporaryWork\\ExistFactTableRepository',
        'trustRepository'       => 'Facades\\App\\Repositories\\DataWareHouse\\TrustWeatherRepository',
        'tableDestination'      => 'original_fact_table',
        'tableTrust'            => 'trust_weather',
        'stateTable'            => 'originalState',

    ],

    'calidad_del_aire' => [

        'typeProcess'           => 'Original',
        'tableSpaceWork'        => 'temporal_air',
        'tableExist'            => 'exist_fact_aire',
        'repositorySpaceWork'   => 'Facades\\App\\Repositories\\TemporaryWork\\TemporalAirRepository',
        'repositoryDestination' => 'Facades\\App\\Repositories\\DataWareHouse\\OriginalFactAirRepository',
        'repositoryExist'       => 'Facades\\App\\Repositories\\TemporaryWork\\ExistFactAirRepository',
        'trustRepository'       => 'Facades\\App\\Repositories\\DataWareHouse\\TrustAirRepository',
        'tableDestination'      => 'original_fact_aire',
        'tableTrust'            => 'trust_air',
        'stateTable'            => 'originalState',
    ],

];