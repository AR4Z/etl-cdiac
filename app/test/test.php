<?php


namespace App\test;

class test
{
    public function waitTime(int $time = 10)
    {
        sleep($time);
        
        echo "waitTime end";
    }

}