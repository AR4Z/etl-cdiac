<?php

return [
    'Filter' =>[
        'weather' => [
            'tableSpaceWork'        => 'temporal_weather',
            'tableExist'            => 'exist_fact_weather',
            'repositorySpaceWork'   => 'Facades\\App\\Repositories\\TemporaryWork\\TemporalWeatherRepository',
            'repositoryDestination' => 'Facades\\App\\Repositories\\DataWareHouse\\WeatherFactRepository',
            'repositoryExist'       => 'Facades\\App\\Repositories\\TemporaryWork\\ExistFactWeatherRepository',
            'trustRepository'       => 'Facades\\App\\Repositories\\DataWareHouse\\WeatherReliabilityRepository',
            'tableDestination'      => 'weather_fact',
            'tableTrust'            => 'weather_reliability',
            'stateTable'            => 'filterState',
            'keys'                  => [
                'station_sk' =>[
                    'external_name' =>  null,
                    'cast_name'     =>  null,
                    'incoming'      =>  false,
                ],
                'date_sk'   =>   [
                    'external_name' =>  'fecha',
                    'cast_name'     =>  'date',
                    'incoming'      =>  true,
                ],
                'time_sk'   =>  [
                    'external_name' =>  'hora',
                    'cast_name'     =>  'time',
                    'incoming'      =>  true,
                ]
            ],
        ],
        'air' => [
            'tableSpaceWork'        => 'temporal_air',
            'tableExist'            => 'exist_fact_air',
            'repositorySpaceWork'   => 'Facades\\App\\Repositories\\TemporaryWork\\TemporalAirRepository',
            'repositoryDestination' => 'Facades\\App\\Repositories\\DataWareHouse\\AirFactRepository',
            'repositoryExist'       => 'Facades\\App\\Repositories\\TemporaryWork\\ExistFactAirRepository',
            'trustRepository'       => 'Facades\\App\\Repositories\\DataWareHouse\\AirReliabilityRepository',
            'tableDestination'      => 'air_fact',
            'tableTrust'            => 'air_reliability',
            'stateTable'            => 'filterState',
            'keys'            => [
                'station_sk' =>[
                    'external_name' =>  null,
                    'cast_name'     =>  null,
                    'incoming'      =>  false,
                    ],
                'date_sk'  =>   [
                    'external_name' =>  'fecha',
                    'cast_name'     =>  'date',
                    'incoming'      =>  true,
                    ],
                'time_sk'   =>  [
                    'external_name' =>  'hora',
                    'cast_name'     =>  'time',
                    'incoming'      =>  true,
                    ]
                ],
        ],
    ],

    'Original'=>[
        'weather' => [
            'tableSpaceWork'        => 'temporal_weather',
            'tableExist'            => 'exist_fact_weather',
            'repositorySpaceWork'   => 'Facades\\App\\Repositories\\TemporaryWork\\TemporalWeatherRepository',
            'repositoryDestination' => 'Facades\\App\\Repositories\\DataWareHouse\\OriginalWeatherFactRepository',
            'repositoryExist'       => 'Facades\\App\\Repositories\\TemporaryWork\\ExistFactWeatherRepository',
            'trustRepository'       => 'Facades\\App\\Repositories\\DataWareHouse\\WeatherReliabilityRepository',
            'tableDestination'      => 'original_weather_fact',
            'tableTrust'            => 'weather_reliability',
            'stateTable'            => 'originalState',
            'keys'                  => [
                'station_sk' =>[
                    'external_name' =>  'station_sk',
                    'cast_name'     =>  'station_sk',
                    'incoming'      =>  true,
                ],
                'date_sk'  =>   [
                    'external_name' =>  'date_sk',
                    'cast_name'     =>  'date_sk',
                    'incoming'      =>  true,
                ],
                'time_sk'   =>  [
                    'external_name' =>  'time_sk',
                    'cast_name'     =>  'time_sk',
                    'incoming'      =>  true,
                ]
            ],
        ],
        'air' => [
            'tableSpaceWork'        => 'temporal_air',
            'tableExist'            => 'exist_fact_air',
            'repositorySpaceWork'   => 'Facades\\App\\Repositories\\TemporaryWork\\TemporalAirRepository',
            'repositoryDestination' => 'Facades\\App\\Repositories\\DataWareHouse\\OriginalFactAirRepository',
            'repositoryExist'       => 'Facades\\App\\Repositories\\TemporaryWork\\ExistFactAirRepository',
            'trustRepository'       => 'Facades\\App\\Repositories\\DataWareHouse\\AirReliabilityRepository',
            'tableDestination'      => 'original_fact_air',
            'tableTrust'            => 'air_reliability',
            'stateTable'            => 'originalState',
            'keys'                  => [
                'station_sk' =>[
                    'external_name' =>  'station_sk',
                    'cast_name'     =>  'station_sk',
                    'incoming'      =>  true,
                ],
                'date_sk'  =>   [
                    'external_name' =>  'date_sk',
                    'cast_name'     =>  'date_sk',
                    'incoming'      =>  true,
                ],
                'time_sk'   =>  [
                    'external_name' =>  'time_sk',
                    'cast_name'     =>  'time_sk',
                    'incoming'      =>  true,
                ]
            ],
        ],
        'groundwater' => [
            'tableSpaceWork'        => 'temporal_groundwater',
            'tableExist'            => 'exist_fact_groundwater',
            'repositorySpaceWork'   => 'Facades\\App\\Repositories\\TemporaryWork\\TemporalGroundwaterRepository',
            'repositoryDestination' => 'Facades\\App\\Repositories\\DataWareHouse\\GroundwaterFactRepository',
            'repositoryExist'       => 'Facades\\App\\Repositories\\TemporaryWork\\ExistFactGroundwaterRepository',
            'trustRepository'       => false,
            'tableDestination'      => 'groundwater_fact',
            'tableTrust'            => false,
            'stateTable'            => 'originalState',
            'keys'                  => [
                'station_sk' =>[
                    'external_name' =>  'station_sk',
                    'cast_name'     =>  'station_sk',
                    'incoming'      =>  true,
                ],
                'date_sk'  =>   [
                    'external_name' =>  'date_sk',
                    'cast_name'     =>  'date_sk',
                    'incoming'      =>  true,
                ],
                'time_sk'   =>  [
                    'external_name' =>  'time_sk',
                    'cast_name'     =>  'time_sk',
                    'incoming'      =>  true,
                ]
            ],
        ],
    ],

];