<?php

use Illuminate\Database\Seeder;

class LevelAlertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('administrator')->table('level_alert')->insert(
            [
                [
                    # id => 1
                    'alert_id'      => 1,
                    'name'          => 'Nivel de alerta uno',
                    'code'          => 'lever-one',
                    'description'   => 'nivel de alerta uno',
                    'level'          => 1,
                    'maximum'        => 299,
                    'minimum'        => 200,
                ],
                [
                    # id => 2
                    'alert_id'      => 1,
                    'name'          => 'Nivel de alerta dos',
                    'code'          => 'lever-two',
                    'description'   => 'nivel de alerta dos',
                    'level'          => 2,
                    'maximum'        => 399,
                    'minimum'        => 300
                ],
                [
                    # id => 3
                    'alert_id'      => 1,
                    'name'          => 'Nivel de alerta tres',
                    'code'          => 'lever-three',
                    'description'   => 'nivel de alerta tres',
                    'level'          => 3,
                    'maximum'        => null,
                    'minimum'        => 400
                ]
            ]
        );
    }
    /**
     * down the database seeds.
     *
     * @return void
     */
    public function down()
    {
        DB::connection('administrator')->table('level_alert')->delete();
    }
}
