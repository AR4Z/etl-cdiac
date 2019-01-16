<?php

use App\Repositories\Administrator\StationRepository;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OriginStateSeeder extends Seeder
{
    protected $stationRepository;

    public function __construct(stationRepository $stationRepository)
    {
        $this->stationRepository = $stationRepository;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $originalsActive = $this->stationRepository->getEtlActive();
        foreach ($originalsActive as $originalActive) {
            DB::connection('administrator')->table('original_state')->insert(
                [
                    'current_date'  => '1990-01-01',
                    'current_time'  => '00:00:00',
                    'station_id'    => $originalActive->id,
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ]
            );
        }
    }

    /**
     * down the database seeds.
     *
     * @return void
     */
    public function down()
    {
        DB::connection('administrator')->table('original_state')->delete();
    }
}