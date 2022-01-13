@if(session()->has('flash_error'))
    <div class="alert alert-danger">{!! session()->get('flash_error') !!}</div>
@endif
@if(session()->has('flash_success'))
    <div class="alert alert-success">{!! session()->get('flash_success') !!}</div>
@endif