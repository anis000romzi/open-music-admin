@extends('master')

@section('title', 'Genres')

@section('nav-genres', 'nav-active')

@section('content')
    <div class="container">
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#newGenreModal">Add new
            genre</button>
        <table id="table-genres" class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Genre</th>
                    <th></th>
                </tr>
            </thead>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="newGenreModal" tabindex="-1" aria-labelledby="newGenreModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="newGenreModalLabel">Add new genre</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('genres.add') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="genre" class="col-form-label">Genre name</label>
                            <input type="text" class="form-control" id="genre" name="genre" required>
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
    <div class="modal fade" id="editGenreModal" tabindex="-1" aria-labelledby="editGenreModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editGenreModalLabel">Edit genre</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editGenreForm">
                        @csrf
                        <div class="mb-3">
                            <input type="hidden" id="genreId" name="genreId">
                            <label for="genreName" class="col-form-label">Genre name</label>
                            <input type="text" class="form-control" id="genreName" name="genreName" required>
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

    <script type="text/javascript">
        $(document).ready(function() {
            $('#table-genres').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: '{{ url('genres/datatable') }}',
                columns: [{
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {
                        data: 'name',
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                            <form action="/genres/delete/${row.id}" method="POST">
                                @csrf
                                <button type="button" class="btn btn-warning btn-sm edit-genre-button" data-id="${row.id}" data-name="${row.name}">Edit</button>
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this genre?')">Delete</button>
                            </form>
                            `
                        }
                    }
                ],
                columnDefs: [{
                    "defaultContent": "-",
                    "targets": "_all",
                }, {
                    "orderable": false,
                    "targets": 2
                }],
            });

            $(document).on('click', '.edit-genre-button', function() {
                console.log('Button clicked');
                $('#genreId').val($(this).data('id'));
                $('#genreName').val($(this).data('name'));
                $('#editGenreModal').modal('show');
            });

            $('#editGenreForm').on('submit', function(e) {
                e.preventDefault();

                var id = $('#genreId').val();
                var name = $('#genreName').val();

                $.ajax({
                    url: '/genres/edit/' + id,
                    type: 'POST',
                    data: {
                        _token: $('input[name=_token]').val(),
                        genreName: name,
                    },
                    success: function(response) {
                        if (response.success) {
                            window.location.href = '/genres';
                        }
                    }
                });
            });
        });
    </script>
@endsection
