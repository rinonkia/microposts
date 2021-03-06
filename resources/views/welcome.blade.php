@extends('layouts.app')

@section('content')
    @if (Auth::check())
        <div class="row">
            <aside class="col-xs-4">
                <div class="panel panel-default">
                    <div class="panel panel-heading">
                        <h3 class="panel-title">{{ $user->name }}</h3>
                    </div>
                    <div class="panel-body">
                        <img class="media-object img-rounded img-responsive" src="{{ Garavatar::src($user->email, 500) }}" alt="">
                    </div>
                </div>
            </aside>
            <div class="col-xs-8">
                @if (count($microposts) > 0)
                    @include('microposts.microposts', ['microposts' => $microposts])
                @endif
            </div>
        </div>
    @else
        <div class="center jumbotron">
            <div class="text-center">
                <h1>Welcome to the Microposts</h1>
                {!! link_to_route('signup.get','sign up now!', null, ['class' => 'btn btn-lg btn-primary']) !!}
            </div>
        </div>
        <div class="col-xs-8 col-xs-offset-2">
            <div>
                <h3>こちらは簡易なTwitterクローンです。</h3>
            </div>
            <div>
                @include('auther_message')
            </div>
        </div>
    @endif
@endsection