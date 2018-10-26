@if (Auth::id() != $micropost->user_id )
    @if (Auth::user()->is_favorite($micropost->id))
        {!! Form::open(['route' => ['micropost.offfavor', $micropost->id ], 'method' => 'delete']) !!}
            {!! Form::submit('unFavorite', ['class' => 'btn btn-default btn-sm']) !!}
        {!! Form::close() !!}
    @else
        {!! Form::open(['route' => ['micropost.onfavor', $micropost->id ]]) !!}
            {!! Form::submit('Favorite', ['class' => 'btn btn-success btn-sm']) !!}
        {!! Form::close() !!}
    @endif
@endif