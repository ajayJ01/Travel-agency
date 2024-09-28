<?php

namespace App\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SearchFlights implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $vendorService;
    protected $searchKey;


    /**
     * Create a new job instance.
     */
    public function __construct($vendorService, $searchKey)
    {
        //prd($vendorService); die('fgfh');
        $this->vendorService = $vendorService;
        $this->searchKey = $searchKey;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {

        Log::info('Job is running', ['vendorService' => $this->vendorService]);
        return $this->vendorService->searchFlight($this->searchKey);
    }

}
