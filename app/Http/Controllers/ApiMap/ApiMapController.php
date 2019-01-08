<?php

namespace App\Http\Controllers\ApiMap;


use App\Http\Controllers\Controller;
use App\Repositories\Administrator\StationRepository;
use Request;

class ApiMapController extends Controller
{
    /**
     * @var \App\Repositories\Administrator\StationRepository
     */
    private $stationRepository;

    /**
     * ApiMapController constructor.
     * @param \App\Repositories\Administrator\StationRepository $stationRepository
     */
    public function __construct(StationRepository $stationRepository)
    {
        $this->stationRepository = $stationRepository;
    }

    /**
     * @return array
     */
    public function getStations() : array
    {
        $stations=$this->stationRepository->listStations();

        foreach ($stations as $station)
        {
            $station->longitude = $this->calculateDecimalCoordinates(
                $station->longitude_degrees,
                $station->longitude_minutes,
                $station->longitude_seconds,
                $station->longitude_direction
            );

            $station->latitude = $this->calculateDecimalCoordinates(
                $station->latitude_degrees,
                $station->latitude_minutes,
                $station->latitude_seconds,
                $station->latitude_direction
            );

        }

        return $stations->toArray();
    }

    public function getStation(Request $request)
    {
        $idStation= $request->get('id');

        # llamar al repositorio y a la funcion que extrae la estacion de la BD
        #retornar la estacion en un formato array
    }

    /**
     * @param $degrees
     * @param $minutes
     * @param $seconds
     * @param $direction
     * @return float
     */
    private function calculateDecimalCoordinates($degrees, $minutes, $seconds, $direction) : float
    {
        $val = ($direction == 'W' or $direction == 'S') ? -1 : 1;
        return round(( ( $degrees + ( $minutes / 60 ) + ( $seconds / 3600 )) * $val ) , 6);
    }

}