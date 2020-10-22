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

    public $profile;
    public $friend;
    public $url;

    public function __construct(Profile $profile, Profile $friend)
    {
        //
        $this->profile = $profile;
        $this->friend = $friend;
        $this->url = config('app.url') . '/profile/' . $profile->username;
    }

    public function build()
    {
        return $this
            ->from('admins@instapp.com')
            ->subject('New follower')
            ->markdown('emails.newFollow');
    }
}
