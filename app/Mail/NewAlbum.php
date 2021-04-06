<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Album;

class NewAlbum extends Mailable
{
    use Queueable, SerializesModels;

    public $album;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Album $album)
    {
        $this->album = $album;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->subject("{$this->album->artist->name} has a new album!")
        ->view('email.new-album')
        ->with('cat', 5);
    }
}
