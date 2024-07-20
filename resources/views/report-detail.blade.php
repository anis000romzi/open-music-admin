@extends('master')

@section('title', $report_detail->song)

@section('nav-reports', 'nav-active')

@section('content')
    <x-breadcrumb :links="[
        ['url' => url('/reports'), 'label' => 'Reports'],
        ['url' => url(`/reports/detail`), 'label' => $report_detail->song],
    ]" />
    <div class="container">
        <h1 class="fw-bold m-0">{{ $report_detail->song }}</h1>
        <p class="fw-bold"><a href="/users/detail/{{ $song_detail->artist }}">by {{ $song_detail->fullname }}</a></p>
        <audio controls controlsList="nodownload">
            <source src="{{ $song_detail->audio }}">
            Your browser does not support the audio tag.
        </audio>
        <p class="m-0 text-secondary">Reported by: {{ '@' . $report_detail->reporter }}</p>
        <p class="m-0 text-secondary">Reason: {{ $report_detail->report_reason }}</p>
        <p class="m-0 text-secondary">Detail: {{ $report_detail->report_detail }}</p>
        <p class="text-secondary">Reported at: {{ $report_detail->created_at }}</p>
        <div class="btn-group">
            @if ($report_detail->status == 'resolved')
                <button type="button" class="btn btn-success dropdown-toggle me-2" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    {{ $report_detail->status }}
                </button>
            @elseif ($report_detail->status == 'reviewed')
                <button type="button" class="btn btn-warning dropdown-toggle me-2" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    {{ $report_detail->status }}
                </button>
            @else
                <button type="button" class="btn btn-danger dropdown-toggle me-2" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    {{ $report_detail->status }}
                </button>
            @endif
            <ul class="dropdown-menu" data-report-id="{{ $report_detail->report_id }}">
                <li><button type="button" class="btn btn-danger dropdown-item" href="#"
                        data-status="pending">pending</button></li>
                <li><button type="button" class="btn btn-warning dropdown-item" href="#"
                        data-status="reviewed">reviewed</button></li>
                <li><button type="button" class="btn btn-success dropdown-item" href="#"
                        data-status="resolved">resolved</button></li>
            </ul>
        </div>
        <button type="button" class="btn btn-warning me-2" data-bs-toggle="modal" data-bs-target="#notifyUser">Notify User</button>
        @if ($report_detail->is_removed)
            <button id="removeSong" type="button" class="btn btn-primary me-2">Recover Song</button>
        @else
            <button id="removeSong" type="button" class="btn btn-danger me-2">Remove Song</button>
        @endif
    </div>

    <!-- Modal -->
    <div class="modal fade" id="notifyUser" tabindex="-1" aria-labelledby="notifyUserLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="notifyUserLabel">Send email to {{ $song_detail->fullname }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.notify', $song_detail->artist) }}" method="POST">
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
            $('.dropdown-menu button').on('click', function() {
                var status = $(this).data('status');
                var reportId = $(this).closest('.dropdown-menu').data('report-id');

                $.ajax({
                    url: '/reports/update-status/' + reportId,
                    type: 'POST',
                    data: {
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            window.location.href = '/reports/detail/' + reportId;
                        }
                    }
                });
            });

            $('#removeSong').on('click', function() {
                $.ajax({
                    url: '/songs/remove/{{ $report_detail->song_id }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            window.location.href =
                                '/reports/detail/{{ $report_detail->report_id }}';
                        }
                    }
                });
            });
        });
    </script>
@endsection
