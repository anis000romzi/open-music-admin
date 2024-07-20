@extends('master')

@section('title', 'Reports')

@section('nav-reports', 'nav-active')

@section('content')
    <div class="container">
        <table id="table-reports" class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Reporter</th>
                    <th>Song</th>
                    <th>Reason</th>
                    <th>Detail</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
        </table>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#table-reports').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: '{{ url('reports/datatable') }}',
                columns: [{
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {
                        data: 'reporter',
                        render: function(data, type, row) {
                            return `@${data}`
                        }
                    },
                    {
                        data: 'song'
                    },
                    {
                        data: 'report_reason',
                    },
                    {
                        data: 'report_detail',
                    },
                    {
                        data: 'status',
                        render: function(data, type, row) {
                            if (data === 'resolved') {
                                return `<span class="badge text-bg-success">${data}</span>`
                            }
                            if (data === 'reviewed') {
                                return `<span class="badge text-bg-warning">${data}</span>`
                            }
                            return `<span class="badge text-bg-danger">${data}</span>` 
                        }
                    },
                    {
                        data: 'report_id',
                        render: function(data, type, row) {
                            return `<a href="/reports/detail/${data}" class="btn btn-primary btn-sm  text-decoration-none">Detail</a>`
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
