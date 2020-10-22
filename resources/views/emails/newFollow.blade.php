<style>
    span{
        text-transform: capitalize;
        font-weight: 700;
    }
</style>

@component('mail::message')
# Hello <span>{{$friend->username}}</span>. You have new Follower!

On {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }} you got new follower:
<span>{{$profile->username}}</span>
<br>
<br>

@component('mail::button', ['url' => $url])
Follower profile
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
