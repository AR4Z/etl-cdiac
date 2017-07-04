<?php


return [

    'Filter' =>[
        'weather' => [
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
        'air' => [
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
    ],

    'Original'=>[
        'weather' => [
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
        'air' => [
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
    ],

];