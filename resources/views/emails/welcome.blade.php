@component('mail::message')
# Welcome to {{config('app.name')}}!

<h3>Hello {!! $user->name.',' !!}</h3>
We are so happy you have joined us! You have successfully signed up for
an {{config('app.name')}} account. You need to verify your email address and
activate your account by clicking the button below.

@component('mail::button', ['url' => url(env('FRONT_URL') . 'verify/'.$user->uuid)])
Confirm Account
@endcomponent

Thank you,<br>
{{ config('app.name') }}
@endcomponent
