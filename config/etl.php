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
        ],
        'air' => [
            'tableSpaceWork'        => 'temporal_air',
            'tableExist'            => 'exist_fact_air',
            'repositorySpaceWork'   => 'Facades\\App\\Repositories\\TemporaryWork\\TemporalAirRepository',
            'repositoryDestination' => 'Facades\\App\\Repositories\\DataWareHouse\\OriginalAirFactRepository',
            'repositoryExist'       => 'Facades\\App\\Repositories\\TemporaryWork\\ExistFactAirRepository',
            'trustRepository'       => 'Facades\\App\\Repositories\\DataWareHouse\\AirReliabilityRepository',
            'tableDestination'      => 'original_air_fact',
            'tableTrust'            => 'air_reliability',
            'stateTable'            => 'originalState',
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
        ],
    ],

    'extraColumns' => [
        'station_sk' =>[
            'type'              =>  'all',
            'local_name'        =>  'station_sk',
            'external_name'     =>  null,
            'cast_name'         =>  null,
            'calculated'        =>  true,
            'local_incoming'    =>  true,
            'external_incoming' =>  false,
            'key'               =>  true,
            'type_data'         =>  'integer',
        ],
        'date_sk'   =>   [
            'type'              =>  'all',
            'local_name'        =>  'date_sk',
            'external_name'     =>  'fecha',
            'cast_name'         =>  'date',
            'calculated'        =>  true,
            'local_incoming'    =>  true,
            'external_incoming' =>  true,
            'key'               =>  true,
            'type_data'         =>  'integer',
        ],
        'time_sk'   =>  [
            'type'              =>  'all',
            'local_name'        =>  'time_sk',
            'external_name'     =>  'hora',
            'cast_name'         =>  'time',
            'calculated'        =>  true,
            'local_incoming'    =>  true,
            'external_incoming' =>  true,
            'key'               =>  true,
            'type_data'         =>  'integer',
        ],
        'accumulated_evapotranspiration'   =>  [
            'type'              =>  'weather',
            'local_name'        =>  'accumulated_evapotranspiration',
            'external_name'     =>  'evapotranspiracion',
            'cast_name'         =>  'accumulated_evapotranspiration',
            'calculated'        =>  false,
            'local_incoming'    =>  true,
            'external_incoming' =>  true,
            'key'               =>  false,
            'type_data'         =>  'double precision',
        ],
        'accumulated_rainfall'   =>  [
            'type'              =>  'weather',
            'local_name'        =>  'accumulated_rainfall',
            'external_name'     =>  'precipitacion',
            'cast_name'         =>  'accumulated_rainfall',
            'calculated'        =>  false,
            'local_incoming'    =>  true,
            'external_incoming' =>  true,
            'key'               =>  false,
            'type_data'         =>  'double precision',
        ],
        'so2_estan_ugm3'   =>  [
            'type'              =>  'air',
            'local_name'        =>  'so2_estan_ugm3',
            'external_name'     =>  'so2_estan_ugm3',
            'cast_name'         =>  'so2_estan_ugm3',
            'calculated'        =>  true,
            'local_incoming'    =>  true,
            'external_incoming' =>  false,
            'key'               =>  false,
            'type_data'         =>  'double precision',
        ],
        'o3_estan_ugm3'   =>  [
            'type'              =>  'air',
            'local_name'        =>  'o3_estan_ugm3',
            'external_name'     =>  'o3_estan_ugm3',
            'cast_name'         =>  'o3_estan_ugm3',
            'calculated'        =>  true,
            'local_incoming'    =>  true,
            'external_incoming' =>  false,
            'key'               =>  false,
            'type_data'         =>  'double precision',
        ],
        'co_estan_ugm3'   =>  [
            'type'              =>  'air',
            'local_name'        =>  'co_estan_ugm3',
            'external_name'     =>  'co_estan_ugm3',
            'cast_name'         =>  'co_estan_ugm3',
            'calculated'        =>  true,
            'local_incoming'    =>  true,
            'external_incoming' =>  false,
            'key'               =>  false,
            'type_data'         =>  'double precision',
        ],
        'comment'   =>  [
            'type'              =>  'all',
            'local_name'        =>  'comment',
            'external_name'     =>  'observaciones',
            'cast_name'         =>  'comment',
            'calculated'        =>  false,
            'local_incoming'    =>  true,
            'external_incoming' =>  true,
            'key'               =>  false,
            'type_data'         =>  'varchar',
        ]
    ],

    'csv_keys'  =>  [
        'weather'       =>  [
            'date_time' => [
                'required'      => true,
                'type'          => 'compound',
                'incoming_name' => 'date_time',
                'local_name'    => 'date_time',
                'description'   => 'Fecha y Hora de la medicion'
            ],
            'fecha' =>  [
                'required'      => true,
                'type'          => 'simple',
                'incoming_name' => 'fecha',
                'local_name'    => 'date',
                'reference'     => 'date_sk',
                'description'   => 'fecha de la medición'
            ],
            'hora'    =>  [
                'required'      => true,
                'type'          => 'simple',
                'incoming_name' => 'hora',
                'local_name'    => 'time',
                'reference'     => 'time_sk',
                'description'   => 'hora de la medición'
            ],
        ],
        'air'   =>  [
            'date_time' => [
                'required'      => true,
                'type'          => 'compound',
                'incoming_name' => 'date_time',
                'local_name'    => 'date_time',
                'description'   => 'Fecha y Hora de la medicion'
            ],
            'fecha' =>  [
                'required'      => true,
                'type'          => 'simple',
                'incoming_name' => 'fecha',
                'local_name'    => 'date',
                'reference'     => 'date_sk',
                'description'   => 'fecha de la medición'
            ],
            'hora'    =>  [
                'required'      => true,
                'type'          => 'simple',
                'incoming_name' => 'hora',
                'local_name'    => 'time',
                'reference'     => 'time_sk',
                'description'   => 'hora de la medición'
            ],

        ],
        'groundwater'   =>  [
            'date_time' => [
                'required'      => true,
                'type'          => 'compound',
                'incoming_name' => 'date_time',
                'local_name'    => 'date_time',
                'description'   => 'Fecha y Hora de la medicion'
            ],
            'fecha' =>  [
                'required'      => true,
                'type'          => 'simple',
                'incoming_name' => 'fecha',
                'local_name'    => 'date',
                'reference'     => 'date_sk',
                'description'   => 'fecha de la medición'
            ],
            'hora'    =>  [
                'required'      => true,
                'type'          => 'simple',
                'incoming_name' => 'hora',
                'local_name'    => 'time',
                'reference'     => 'time_sk',
                'description'   => 'hora de la medición'
            ],
        ],

    ],

];