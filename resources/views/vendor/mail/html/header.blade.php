@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
<img height="80" width="80" src="{{ getPath('web') }}/img/logo.png" alt="Z-Zone" class="img-fluid"/>
@endif
</a>
</td>
</tr>
