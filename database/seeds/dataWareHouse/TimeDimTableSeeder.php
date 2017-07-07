<?php

use Illuminate\Database\Seeder;
use Jenssegers\Date\Date;
use App\Entities\DataWareHouse\TimeDim;

class TimeDimTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $firstDate = Date::create(2017, 6, 20, 0, 0, 0);
        $lastDate = Date::create(2017, 6, 20, 0, 0, 0);

        while ($firstDate->diffInHours($lastDate) < 24){

            $part_day = "";

            if($firstDate->hour >= 0 && $firstDate->hour < 6){
                $part_day = "madrugada";
            }else if($firstDate->hour >= 6 && $firstDate->hour < 12){
                $part_day = "mañana";
            }else if($firstDate->hour >= 12 && $firstDate->hour < 18){
                $part_day = "tarde";
            }else if($firstDate->hour >= 18 && $firstDate->hour < 24){
                $part_day = "noche";
            }


            TimeDim::create([
                'time' => $firstDate->format('H:i:s'),
                'hours' => $firstDate->hour,
                'minutes' => $firstDate->minute,
                'seconds' => $firstDate->second,
                'part_day' => $part_day,
            ]);

            $firstDate->addSecond();
        }

        TimeDim::create([
            'hours' => 99,
            'minutes' => 99,
            'seconds' => 99,
        ]);
    }
}
