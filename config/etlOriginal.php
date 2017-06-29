<?php

return [

    'meteorologica' => [

        'typeProcess'           => 'Original',
        'tableSpaceWork'        => 'temporal_weather',
        'tableExist'            => 'exist_fact_table',
        'repositorySpaceWork'   => 'Facades\\App\\Repositories\\temporaryWork\\TemporalWeatherRepository',
        'repositoryDestination' => 'Facades\\App\\Repositories\\dataWareHouse\\OriginalFactTableRepository',
        'repositoryExist'       => 'Facades\\App\\Repositories\\temporaryWork\\ExistFactTableRepository',
        'trustRepository'       => 'Facades\\App\\Repositories\\dataWareHouse\\TrustWeatherRepository',
        'tableDestination'      => 'original_fact_table',
        'tableTrust'            => 'trust_weather',
        'stateTable'            => 'originalState',

    ],

    'hidrometeorologica' => [

        'typeProcess'           => 'Original',
        'tableSpaceWork'        => 'temporal_weather',
        'tableExist'            => 'exist_fact_table',
        'repositorySpaceWork'   => 'Facades\\App\\Repositories\\temporaryWork\\TemporalWeatherRepository',
        'repositoryDestination' => 'Facades\\App\\Repositories\\dataWareHouse\\OriginalFactTableRepository',
        'repositoryExist'       => 'Facades\\App\\Repositories\\temporaryWork\\ExistFactTableRepository',
        'trustRepository'       => 'Facades\\App\\Repositories\\dataWareHouse\\TrustWeatherRepository',
        'tableDestination'      => 'original_fact_table',
        'tableTrust'            => 'trust_weather',
        'stateTable'            => 'originalState',

    ],

    'solo_precipitacion' => [

        'typeProcess'           => 'Original',
        'tableSpaceWork'        => 'temporal_weather',
        'tableExist'            => 'exist_fact_table',
        'repositorySpaceWork'   => 'Facades\\App\\Repositories\\temporaryWork\\TemporalWeatherRepository',
        'repositoryDestination' => 'Facades\\App\\Repositories\\dataWareHouse\\OriginalFactTableRepository',
        'repositoryExist'       => 'Facades\\App\\Repositories\\temporaryWork\\ExistFactTableRepository',
        'trustRepository'       => 'Facades\\App\\Repositories\\dataWareHouse\\TrustWeatherRepository',
        'tableDestination'      => 'original_fact_table',
        'tableTrust'            => 'trust_weather',
        'stateTable'            => 'originalState',

    ],

    'calidad_del_aire' => [

        'typeProcess'           => 'Original',
        'tableSpaceWork'        => 'temporal_air',
        'tableExist'            => 'exist_fact_aire',
        'repositorySpaceWork'   => 'Facades\\App\\Repositories\\temporaryWork\\TemporalAirRepository',
        'repositoryDestination' => 'Facades\\App\\Repositories\\dataWareHouse\\OriginalFactAirRepository',
        'repositoryExist'       => 'Facades\\App\\Repositories\\temporaryWork\\ExistFactAirRepository',
        'trustRepository'       => 'Facades\\App\\Repositories\\dataWareHouse\\TrustAirRepository',
        'tableDestination'      => 'original_fact_aire',
        'tableTrust'            => 'trust_air',
        'stateTable'            => 'originalState',
    ],

];