<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Stats extends Mailable
{
    use Queueable, SerializesModels;

    public $artist;
    public $playlist;
    public $track;

    /**
     * Create a new message instance.
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
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->subject("See the current user statistics!")
        ->view('email.stats');
    }
}
