@if (Session::has('message'))
    <div class="alert alert-info">
        <button type="submit" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        {{ Session::get('message') }}
    </div>
@endif

@if(Session::has('success'))
    <div class="alert alert-success">
        <button type="submit" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        {{ Session::get('success') }}
    </div>
@endif

@if(Session::has('danger')).
    <div class="alert alert-danger">
        <button type="submit" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        {{ Session::get('danger') }}
    </div>
@endif