<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Artist;
use Illuminate\Support\Facades\Mail;
use App\Mail\Stats;
use Exception;

class SendStats implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $artist;
    protected $playlist;
    protected $track;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $artist, int $playlist, int $track)
    {
        $this->artist = $artist;
        $this->playlist = $playlist;
        $this->track = $track;
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
                Mail::to($user->email)->send(new Stats($this->artist, $this->playlist, $this->track));
            }
            else
            {
                throw new Exception("User {$user->id} is missing an email.");
            }
        }
    }
}
