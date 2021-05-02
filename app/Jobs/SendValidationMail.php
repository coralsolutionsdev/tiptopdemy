<?php

namespace App\Jobs;

use App\Mail\ValidationMail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendValidationMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data;

    /**
     * Create a new job instance.
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->data =  $data;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $receiverData = $this->data;
        try {
            Mail::to($receiverData['receiver_email'])->send(new ValidationMail($receiverData));
            Log::info('Activation email sent');
        } catch (\Exception $e) {
            Log::error($e->getMessage() . ' ' . $e->getTraceAsString());
        }
    }

}
