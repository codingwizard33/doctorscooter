@component('mail::message')
# Notification!

Your repair order!
<br>
{{$message}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
