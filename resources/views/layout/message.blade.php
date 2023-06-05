@if ($errors->any())
    @foreach ($errors as $e)
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>{{$e->message}}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    @endforeach

@endif


@if (session()->has('success'))

<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{session()->get('success')}}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

@endif

@if (session()->has('warning'))

<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{session()->get('warning')}}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

@endif

