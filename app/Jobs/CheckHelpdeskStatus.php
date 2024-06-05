<?php

namespace App\Jobs;

use App\Helpdesk;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Carbon\Carbon;

class CheckHelpdeskStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tickets = Helpdesk::with('priority')->where('status_id', 1)->get(); // Assuming status_id 1 is 'Open'
        
        foreach ($tickets as $ticket) {
            $escalation_time = match ($ticket->priority->name) {
                'High' => 4,
                'Critical' => 2,
                'Medium' => 8,
                'Low' => 16,
                default => 0,
            };

            $time_limit = $ticket->created_at->addHours($escalation_time);
            if (Carbon::now()->greaterThanOrEqualTo($time_limit)) {
                $ticket->update(['status_id' => 2]); // Assuming status_id 2 is 'Closed'
            }
        }
    }
}
