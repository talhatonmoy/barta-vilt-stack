<?php

namespace App\Listeners;

use App\Mail\User\AccountConfirmationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendAccountConfirmationMail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
    // Send Account Confirmation Email
        Mail::to($event->user->email)->send(new AccountConfirmationMail($event->user));
    }
}
