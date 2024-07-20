<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Album;
use DataTables;

class AlbumController extends Controller
{
    public function index()
    {
        return view('albums');
    }

    public function getDataTable()
    {
        $data = Album::join('users', 'albums.artist', '=', 'users.id')
            ->select('albums.id as album_id', '*')
            ->get();

        return DataTables::of($data)->make(true);
    }
}
