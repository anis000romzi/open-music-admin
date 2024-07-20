@extends('master')

@section('title', 'Home')

@section('nav-home', 'nav-active')

@section('content')
    <div class="container">
        <h1>Welcome, {{ Auth::user()->username }}!</h1>
        <div class="d-flex flex-wrap p-2">
            <div class="card m-1" style="width: 18rem;">
                <a href="{{ route('users') }}" class="text-decoration-none text-light">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fa-solid fa-user"></i> {{ $registered_users_count }}</h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary">Registered users</h6>
                    </div>
                </a>
            </div>
            <div class="card m-1" style="width: 18rem;">
                <a href="{{ route('users') }}" class="text-decoration-none text-light">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fa-solid fa-user-check"></i> {{ $active_users_count }}</h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary">Active users</h6>
                    </div>
                </a>
            </div>
            <div class="card m-1" style="width: 18rem;">
                <a href="{{ route('songs') }}" class="text-decoration-none text-light">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fa-solid fa-music"></i> {{ $songs_count }}</h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary">Songs</h6>
                    </div>
                </a>
            </div>
            <div class="card m-1" style="width: 18rem;">
                <a href="{{ route('albums') }}" class="text-decoration-none text-light">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fa-solid fa-compact-disc"></i> {{ $albums_count }}</h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary">Albums</h6>
                    </div>
                </a>
            </div>
        </div>
        <div class="d-flex">
            <div class="p-2">
                <h3>Recent Users</h3>
                @foreach ($recent_users as $users)
                    <a href="/users/detail/{{ $users->id }}" class="text-decoration-none text-light">
                        <div class="p-2 mb-1 bg-dark-subtle" style="max-width: 300px;">
                            <div class="row g-2 align-items-center">
                                <div class="col-md-4 p-1">
                                    <img src="{{ $users->picture }}" class="img-fluid rounded-circle"
                                        alt="{{ $users->fullname }}" style="width: 100px">
                                </div>
                                <div class="col-md-8">
                                    <h5 class="m-0">{{ $users->fullname }}</h5>
                                    <p class="m-0">{{ '@' . $users->username }}</p>
                                    <p class="m-0"><small
                                            class="text-body-secondary">{{ timeago($users->created_at) }}</small></p>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="p-2">
                <h3>Recent Songs</h3>
                @foreach ($recent_songs as $songs)
                    <div class="p-2 mb-1 bg-dark-subtle" style="max-width: 300px;">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-4 p-1">
                                @if ($songs->cover)
                                    <img src="{{ $songs->cover }}" class="img-fluid" alt="{{ $songs->title }}"
                                        style="width: 100px">
                                @else
                                    <img src="{{ asset('default-image.png') }}" class="img-fluid"
                                        alt="{{ $songs->title }}" style="width: 100px">
                                @endif
                            </div>
                            <div class="col-md-8">
                                <h5 class="m-0">{{ $songs->title }}</h5>
                                <p class="m-0">{{ $songs->fullname }}</p>
                                <p class="m-0"><small
                                        class="text-body-secondary">{{ timeago($songs->created_at) }}</small></p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="p-2">
                <h3>Recent Albums</h3>
                @foreach ($recent_albums as $albums)
                    <div class="p-2 mb-1 bg-dark-subtle" style="max-width: 300px;">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-4 p-1">
                                @if ($albums->cover)
                                    <img src="{{ $albums->cover }}" class="img-fluid" alt="{{ $albums->name }}"
                                        style="width: 100px">
                                @else
                                    <img src="{{ asset('default-image.png') }}" class="img-fluid"
                                        alt="{{ $albums->name }}" style="width: 100px">
                                @endif
                            </div>
                            <div class="col-md-8">
                                <h5 class="m-0">{{ $albums->name }}</h5>
                                <p class="m-0">{{ $albums->fullname }}</p>
                                <p class="m-0"><small
                                        class="text-body-secondary">{{ timeago($albums->created_at) }}</small></p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
