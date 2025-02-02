<?php

namespace App\Jobs;

use App\Models\Job;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class TranslateJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Job $jobListing)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // For example we could have an api call to some AI to translate the job listing's description (if there is one)
        // AI::translate($this->>jobListing->description, 'spanish');
        logger('Translating '. $this->jobListing->title . ' to Spanish.');
    }
}
