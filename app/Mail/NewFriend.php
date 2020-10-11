<?php

namespace App\Mail;

use App\Profile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewFriend extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var Profile
     */
    public $profile;
    /**
     * @var Profile
     */
    public $friend;


    public $url;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Profile $profile, Profile $friend)
    {
        //
        $this->profile = $profile;
        $this->friend = $friend;
        $this->url = config('app.url') . '/profile/' . $profile->username;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('admins@instapp.com')
            ->subject('New follower')
            ->markdown('emails.newFollow');
    }
}
