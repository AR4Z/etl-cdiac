<?php

use Illuminate\Database\Seeder;
use App\Entities\DataWareHouse\DateDim;
use Jenssegers\Date\Date;

class DateDimTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $firstDate = Date::createFromDate(1940, 1, 1);
        $lastDate = Date::createFromDate(2030, 12, 31);
        $firstLustrumYear = $firstDate->year;
        $lastLustrumYear = $firstDate->year + 4;

        while ($firstDate->diffInDays($lastDate) != 0){
            if($firstDate->year < $firstLustrumYear || $firstDate->year > $lastLustrumYear){
                $firstLustrumYear = $lastLustrumYear + 1;
                $lastLustrumYear = $firstLustrumYear + 4;
            }

            $lustrum = $firstLustrumYear."-".$lastLustrumYear;

            DateDim::create([
                'date' => $firstDate->format('Y-m-d'),
                'year' => $firstDate->year,
                'month' => $firstDate->month,
                'day' => $firstDate->day,
                'week_day' => $firstDate->dayOfWeek,
                'week_year' => $firstDate->weekOfYear,
                'quarter' => $firstDate->quarter,
                'semester' => ($firstDate->quarter > 2) ? 2 : 1,
                'lustrum' => $lustrum,
                'month_name' => $firstDate->format('F'),
                'day_name' => $firstDate->format('l'),
            ]);

            $firstDate->addDay();
        }
    }
}
