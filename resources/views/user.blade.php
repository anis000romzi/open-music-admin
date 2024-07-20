@extends('master')

@section('title', 'Users')

@section('nav-users', 'nav-active')

@section('content')
    <div class="container">
        @if (session('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <button type="button" class="btn btn-danger mb-3" data-bs-toggle="modal" data-bs-target="#logoutUsersModal">Logout
            all
            users</button>
        {{-- <button type="button" class="btn btn-primary">Notify all users</button> --}}
        <table id="table-users" class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Picture</th>
                    <th>Fullname</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="logoutUsersModal" tabindex="-1" aria-labelledby="logoutUsersModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="logoutUsersModalLabel">Confirm logout</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to logout all users?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form action="{{ route('users.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary" id="logoutUsers">Confirm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#table-users').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: '{{ url('users/datatable') }}',
                columns: [{
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {
                        data: 'picture',
                        render: function(data, type, row) {
                            return `<img src="${data}" class="img-fluid rounded-circle" alt="Song Cover" style="width: 50px">`;
                        }
                    },
                    {
                        data: 'fullname'
                    },
                    {
                        data: 'username',
                        render: function(data, type, row) {
                            return `@${data}`
                        }
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'is_active',
                        render: function(data, type, row) {
                            return `${data ? '<span class="badge text-bg-success">Active</span>' : '<span class="badge text-bg-danger">Inactive</span>'}`
                        }
                    },
                    {
                        data: 'id',
                        render: function(data, type, row) {
                            return `<a href="/users/detail/${data}" class="btn btn-primary btn-sm text-decoration-none">Detail</a>`
                        }
                    }
                ],
                columnDefs: [{
                    "defaultContent": "-",
                    "targets": "_all",
                }, {
                    "orderable": false,
                    "targets": 3
                }],
            });
        });
    </script>
@endsection
