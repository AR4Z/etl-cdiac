<?php

namespace App\Jobs;

use App\Mail\OrderShippedTest;
use App\test\test;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;

class testJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var test
     */
    private $test;

    /**
     * Create a new job instance.
     *
     * @param string $test
     */
    public function __construct(string $test)
    {
        $this->test = $test;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Exception
     */
    public function handle()
    {
        throw new Exception("I am throwing this exception", 1);
        Mail::to($this->test)->send(new OrderShippedTest());
    }
}
