<?php


return [

    'Filter' =>[
        'weather' => [
            'tableSpaceWork'        => 'temporal_weather',
            'tableExist'            => 'exist_fact_weather',
            'repositorySpaceWork'   => 'Facades\\App\\Repositories\\TemporaryWork\\TemporalWeatherRepository',
            'repositoryDestination' => 'Facades\\App\\Repositories\\DataWareHouse\\FactTableRepository',
            'repositoryExist'       => 'Facades\\App\\Repositories\\TemporaryWork\\ExistFactTableRepository',
            'trustRepository'       => 'Facades\\App\\Repositories\\DataWareHouse\\TrustWeatherRepository',
            'tableDestination'      => 'weather_fact',
            'tableTrust'            => 'trust_weather',
            'stateTable'            => 'filterState',
        ],
        'air' => [
            'tableSpaceWork'        => 'temporal_air',
            'tableExist'            => 'exist_fact_air',
            'repositorySpaceWork'   => 'Facades\\App\\Repositories\\TemporaryWork\\TemporalAirRepository',
            'repositoryDestination' => 'Facades\\App\\Repositories\\DataWareHouse\\FactAirRepository',
            'repositoryExist'       => 'Facades\\App\\Repositories\\TemporaryWork\\ExistFactAirRepository',
            'trustRepository'       => 'Facades\\App\\Repositories\\DataWareHouse\\TrustAirRepository',
            'tableDestination'      => 'air_fact',
            'tableTrust'            => 'trust_air',
            'stateTable'            => 'filterState',
        ],
    ],

    'Original'=>[
        'weather' => [
            'tableSpaceWork'        => 'temporal_weather',
            'tableExist'            => 'exist_fact_weather',
            'repositorySpaceWork'   => 'Facades\\App\\Repositories\\TemporaryWork\\TemporalWeatherRepository',
            'repositoryDestination' => 'Facades\\App\\Repositories\\DataWareHouse\\OriginalFactTableRepository',
            'repositoryExist'       => 'Facades\\App\\Repositories\\TemporaryWork\\ExistFactTableRepository',
            'trustRepository'       => 'Facades\\App\\Repositories\\DataWareHouse\\TrustWeatherRepository',
            'tableDestination'      => 'original_fact_weather',
            'tableTrust'            => 'trust_weather',
            'stateTable'            => 'originalState',
        ],
        'air' => [
            'tableSpaceWork'        => 'temporal_air',
            'tableExist'            => 'exist_fact_air',
            'repositorySpaceWork'   => 'Facades\\App\\Repositories\\TemporaryWork\\TemporalAirRepository',
            'repositoryDestination' => 'Facades\\App\\Repositories\\DataWareHouse\\OriginalFactAirRepository',
            'repositoryExist'       => 'Facades\\App\\Repositories\\TemporaryWork\\ExistFactAirRepository',
            'trustRepository'       => 'Facades\\App\\Repositories\\DataWareHouse\\TrustAirRepository',
            'tableDestination'      => 'original_fact_air',
            'tableTrust'            => 'trust_air',
            'stateTable'            => 'originalState',
        ],
    ],

];