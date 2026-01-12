<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Persons;
use App\Mail\PersonAdded;
use Illuminate\Support\Facades\Mail;

class EmailPerson implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Persons $person,
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $emails=explode(";",$this->person->emails);
        foreach($emails as $email){
            Mail::to($email)->send(new PersonAdded($this->person));
        }
    }
}
