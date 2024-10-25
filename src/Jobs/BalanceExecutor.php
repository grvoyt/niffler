<?php

namespace Grvoyt\Niffler\Jobs;

use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class BalanceExecutor implements ShouldQueue, ShouldBeUnique
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public int $user_id)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        sleep(100);
    }

    /**
     * Get the unique ID for the job.
     */
    public function uniqueId(): string
    {
        return $this->user_id;
    }
}
