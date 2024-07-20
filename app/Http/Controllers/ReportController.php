<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Report;
use App\Models\Song;
use DataTables;

class ReportController extends Controller
{
    public function index()
    {
        return view('report');
    }

    public function detail(Request $request)
    {
        $report_id = $request->route('id');

        $report_detail = Report::join('users', 'reports.reporter', '=', 'users.id')
            ->leftJoin('songs', 'reports.song_id', '=', 'songs.id')
            ->select(
                'reports.id as report_id',
                'users.username as reporter',
                'songs.id as song_id',
                'songs.title as song',
                'songs.is_removed',
                'reports.report_reason',
                'reports.report_detail',
                'reports.status',
                'reports.created_at'
            )
            ->where('reports.id', $report_id)
            ->first();

        $song_detail = Song::join('users', 'songs.artist', '=', 'users.id')
            ->select('songs.id as song_id', '*')
            ->where('songs.id', $report_detail->song_id)
            ->first();

        $data = [
            'report_detail' => $report_detail,
            'song_detail' => $song_detail,
        ];

        return view('report-detail', $data);
    }

    public function updateReportStatus(Request $request)
    {
        $id_report = $request->route('idReport');

        $data = $request->validate([
            'status' => 'required|string',
        ]);

        Report::where('id', $id_report)->update(['status' => $data['status']]);

        return response()->json(['success' => true]);
    }

    public function getDataTable()
    {
        $data = Report::join('users', 'reports.reporter', '=', 'users.id')
            ->leftJoin('songs', 'reports.song_id', '=', 'songs.id')
            ->select('reports.id as report_id', 'users.username as reporter', 'songs.title as song', 'reports.report_reason', 'reports.report_detail', 'reports.status')
            ->get();

        return DataTables::of($data)->make(true);
    }
}
