
@component('mail::message')
<div>From : {{$name}}</div>
<div>Email: {{$email}}</div>
<div>Subject: {{$subject}}
</div>
{{$body}}

Thanks,<br>

{{ $site->name }}
@endcomponent

