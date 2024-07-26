<?php

namespace App\Jobs;

use App\Models\LegalitasOffice;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class LegalitasScheduler implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public LegalitasOffice $legalitas,)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $update_status = DB::table('legalitas_office')->where('berakhir', '<', now()->update(['status' => 3]));
    }
}
