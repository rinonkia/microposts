
@if (count($errors) > 0 )
    @foreach ($errors->all() an $error)
        <div class="alert alert-warning">{{ $error }}</div>
    @endforeach
@endif