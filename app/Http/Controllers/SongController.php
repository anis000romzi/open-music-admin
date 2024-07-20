<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Song;
use DataTables;

class SongController extends Controller
{
    public function index()
    {
        return view('songs');
    }

    public function removeSong(Request $request)
    {
        $id_song = $request->route('id');

        $is_song_removed = Song::where('id', $id_song)->select('is_removed')->first();

        if ($is_song_removed->is_removed) {
            Song::where('id', $id_song)->update(['is_removed' => false]);
        } else {
            Song::where('id', $id_song)->update(['is_removed' => true]);
        }

        return response()->json(['success' => true]);
    }

    public function getDataTable()
    {
        $data = Song::join('users', 'songs.artist', '=', 'users.id')
            ->select('songs.id as song_id', '*')
            ->get();

        return DataTables::of($data)->make(true);
    }
}
