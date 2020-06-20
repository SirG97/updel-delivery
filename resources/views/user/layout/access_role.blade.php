 @php
    $priviledge = app\classes\Session::get('priviledge');
@endphp
@if($priviledge === 'Admin')
    @extends('user.layout.base')
@elseif($priviledge === 'Manager')
    @extends('user.layout.manager')
@elseif($priviledge === 'Customer Service Adviser')
    @extends('user.layout.support')
@elseif($priviledge === 'Rider')
    @extends('user.layout.rider')
@endif

