<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Album;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewAlbum;
use Exception;

class AnnounceNewAlbum implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $album;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Album $album)
    {
        $this->album = $album;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            if ($user->email)
            {
                Mail::to($user->email)->send(new NewAlbum($this->album));
            }
            else
            {
                throw new Exception("User {$user->id} is missing an email.");
            }
        }
    }
}