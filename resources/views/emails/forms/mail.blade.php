@component('mail::message')
<b>Contact email</b>
<br><br>
@foreach($contentItems as $item)
    <b>{{$item['label']}}</b>:<br>
    {{$item['value']}}<br>
@endforeach

Thanks,<br>
@endcomponent
