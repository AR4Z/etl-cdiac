<?php


return [

    'meteorologica' => [

        'typeProcess'           => 'Filter',
        'tableSpaceWork'        => 'temporal_weather',
        'tableExist'            => 'exist_fact_table',
        'repositorySpaceWork'   => 'Facades\\App\\Repositories\\temporaryWork\\TemporalWeatherRepository',
        'repositoryDestination' => 'Facades\\App\\Repositories\\dataWareHouse\\FactTableRepository',
        'repositoryExist'       => 'Facades\\App\\Repositories\\temporaryWork\\ExistFactTableRepository',
        'trustRepository'       => 'Facades\\App\\Repositories\\dataWareHouse\\TrustWeatherRepository',
        'tableTrust'            => 'trust_weather',
        'tableDestination'      => 'fact_table',
        'stateTable'            => 'filterState',

    ],

    'hidrometeorologica' => [

        'typeProcess'           => 'Filter',
        'tableSpaceWork'        => 'temporal_weather',
        'tableExist'            => 'exist_fact_table',
        'repositorySpaceWork'   => 'Facades\\App\\Repositories\\temporaryWork\\TemporalWeatherRepository',
        'repositoryDestination' => 'Facades\\App\\Repositories\\dataWareHouse\\FactTableRepository',
        'repositoryExist'       => 'Facades\\App\\Repositories\\temporaryWork\\ExistFactTableRepository',
        'trustRepository'       => 'Facades\\App\\Repositories\\dataWareHouse\\TrustWeatherRepository',
        'tableDestination'      => 'fact_table',
        'tableTrust'            => 'trust_weather',
        'stateTable'            => 'filterState',

    ],

    'solo_precipitacion' => [

        'typeProcess'           => 'Filter',
        'tableSpaceWork'        => 'temporal_weather',
        'tableExist'            => 'exist_fact_table',
        'repositorySpaceWork'   => 'Facades\\App\\Repositories\\temporaryWork\\TemporalWeatherRepository',
        'repositoryDestination' => 'Facades\\App\\Repositories\\dataWareHouse\\FactTableRepository',
        'repositoryExist'       => 'Facades\\App\\Repositories\\temporaryWork\\ExistFactTableRepository',
        'trustRepository'       => 'Facades\\App\\Repositories\\dataWareHouse\\TrustWeatherRepository',
        'tableDestination'      => 'fact_table',
        'tableTrust'            => 'trust_weather',
        'stateTable'            => 'filterState',

    ],

    'calidad_del_aire' => [

        'typeProcess'           => 'Filter',
        'tableSpaceWork'        => 'temporal_air',
        'tableExist'            => 'exist_fact_air',
        'repositorySpaceWork'   => 'Facades\\App\\Repositories\\temporaryWork\\TemporalAirRepository',
        'repositoryDestination' => 'Facades\\App\\Repositories\\dataWareHouse\\FactAirRepository',
        'repositoryExist'       => 'Facades\\App\\Repositories\\temporaryWork\\ExistFactAirRepository',
        'trustRepository'       => 'Facades\\App\\Repositories\\dataWareHouse\\TrustAirRepository',
        'tableDestination'      => 'fact_aire',
        'tableTrust'            => 'trust_air',
        'stateTable'            => 'filterState',

    ],

];