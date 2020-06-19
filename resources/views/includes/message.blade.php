<div>
@if(isset($errors) && $errors != false && is_array($errors))
<div class="alert alert-danger alert-dismissible" role="alert">
    @foreach($errors as $error)
        @foreach($error as $error_item)
            <p>{{ $error_item }}</p>
        @endforeach
    @endforeach
</div>
@elseif(App\Classes\Session::has('error'))
    <div class="alert alert-danger  alert-dismissible" role="alert">
        {{ App\Classes\Session::flash('error') }}
    </div>

@endif


@if(isset($success) && !empty($success))
    <div class="alert alert-success  alert-dismissible" role="alert">
        {{ $success }}
    </div>
@elseif(App\Classes\Session::has('success'))
    <div class="alert alert-success  alert-dismissible" role="alert">
        {{ App\Classes\Session::flash('success') }}
    </div>

@endif
</div>
