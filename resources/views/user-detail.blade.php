@extends('master')

@section('title', $user_detail->fullname)

@section('nav-users', 'nav-active')

@section('content')
    <x-breadcrumb :links="[
        ['url' => url('/users'), 'label' => 'User'],
        ['url' => url(`/users/detail`), 'label' => $user_detail->fullname],
    ]" />
    <div class="container">
        <img src="{{ $user_detail->picture }}" class="img-fluid rounded-circle" alt="{{ $user_detail->fullname }}"
            style="width: 200px">
        <h1 class="fw-bold m-0">{{ $user_detail->fullname }}</h1>
        <p class="m-0 text-secondary">{{ '@' . $user_detail->username }}</p>
        <p class="text-secondary">{{ $user_detail->email }}</p>
        <p>{{ $user_detail->description ? $user_detail->description : 'No description' }}</p>

        @if ($user_detail->is_active)
            <button id="activateUser" type="button" class="btn btn-warning me-2">Deactivate User</button>
        @else
            <button id="activateUser" type="button" class="btn btn-primary me-2">Activate User</button>
            <form action="{{ route('users.delete', $user_detail->id) }}" method="POST" class="d-inline-block">
                @csrf
                <button id="deleteUser" type="submit" class="btn btn-warning me-2"
                    onclick="return confirm('Are you sure you want to delete this user?')">Delete User</button>
            </form>
        @endif
        <button type="button" class="btn btn-info me-2" data-bs-toggle="modal" data-bs-target="#notifyUser">Notify User</button>
        @if ($user_detail->is_banned)
            <button id="banUser" type="button" class="btn btn-success me-2">Unban User</button>
        @else
            <button id="banUser" type="button" class="btn btn-danger me-2">Ban User</button>
        @endif
    </div>

    <!-- Modal -->
    <div class="modal fade" id="notifyUser" tabindex="-1" aria-labelledby="notifyUserLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="notifyUserLabel">Send email to {{ $user_detail->fullname }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.notify', $user_detail->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="subject" class="col-form-label">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                            <label for="content" class="col-form-label">Content</label>
                            <textarea type="text" class="form-control" id="content" name="content" required></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Confirm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#activateUser').on('click', function() {
                $.ajax({
                    url: '/users/activate/{{ $user_detail->id }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            window.location.href = '/users/detail/{{ $user_detail->id }}';
                        }
                    }
                });
            });

            $('#banUser').on('click', function() {
                $.ajax({
                    url: '/users/ban/{{ $user_detail->id }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            window.location.href = '/users/detail/{{ $user_detail->id }}';
                        }
                    }
                });
            });
        });
    </script>
@endsection
