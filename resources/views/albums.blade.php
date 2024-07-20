@extends('master')

@section('title', 'Albums')

@section('nav-albums', 'nav-active')

@section('content')
    <div class="container">
        <table id="table-albums" class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Cover</th>
                    <th>Name</th>
                    <th>Artist</th>
                    <th>Year</th>
                    <th></th>
                </tr>
            </thead>
        </table>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#table-albums').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: '{{ url('albums/datatable') }}',
                columns: [{
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {
                        data: 'cover',
                        render: function(data, type, row) {
                            return data ?
                                `<img src="${data}" class="img-fluid" alt="Album Cover" style="width: 50px">` :
                                `<img src="{{ asset('default-image.png') }}" class="img-fluid" alt="Song Cover" style="width: 50px">`
                        }
                    },
                    {
                        data: 'name',
                    },
                    {
                        data: 'fullname'
                    },
                    {
                        data: 'year',
                    },
                    {
                        data: 'album_id',
                        render: function(data, type, row) {
                            return `<a href="/album/detail/${data}" class="btn btn-primary btn-sm  text-decoration-none">Detail</a>`
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
