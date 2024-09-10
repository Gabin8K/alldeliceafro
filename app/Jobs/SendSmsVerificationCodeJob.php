<?php

namespace App\Jobs;

use App\Mail\ReportSendingSmsErrorMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendSmsVerificationCodeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public int $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private string $phone,
        private string $message,
    )
    {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Http::retry(3, 100)->withQueryParameters([
            'phone' => App::isProduction() ? $this->phone : config('services.sms_gateway.test_phone'),
            'message' => $this->message,
            'sim_slot' => config('services.sms_gateway.sim_slot'),
        ])->get(config('services.sms_gateway.host') . '/v1/sms/send/');
    }

    /**
     * Handle a job failure.
     */
    public function failed(Throwable $exception): void
    {
        Mail::to(config('app.dev_mail'))->send(new ReportSendingSmsErrorMail($this->phone));
    }
}
