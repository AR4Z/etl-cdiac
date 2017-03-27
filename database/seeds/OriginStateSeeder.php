<?php

use Illuminate\Database\Seeder;
use App\Repositories\Config\StationRepository;
use Carbon\Carbon;

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
      $originalsActive = $this->stationRepository->getActive();

      foreach ($originalsActive as $originalActive) {
        DB::connection('config')->table('original_state')->insert(
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
}
