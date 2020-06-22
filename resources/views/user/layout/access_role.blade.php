 @php
    $priviledge = App\Classes\Session::get('priviledge');
@endphp
@if($priviledge === 'Admin')
    @extends('user.layout.base')
@elseif($priviledge === 'Manager')
    @extends('user.layout.managermenu')
@elseif($priviledge === 'Customer Service Adviser')
    @extends('user.layout.supportmenu')
@elseif($priviledge === 'Rider')
    @extends('user.layout.ridermenu')
@endif

