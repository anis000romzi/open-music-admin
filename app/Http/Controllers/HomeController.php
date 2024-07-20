<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $registered_users_count = DB::table('users')->count();
        $active_users_count = DB::table('users')->where('is_active', '=', true)->count();
        $songs_count = DB::table('songs')->count();
        $albums_count = DB::table('albums')->count();
        $recent_users = DB::table('users')->orderBy('created_at', 'desc')->limit(5)->get();
        $recent_songs = DB::table('songs')->join('users', 'users.id', '=', 'songs.artist')->orderBy('songs.created_at', 'desc')->limit(5)->get();
        $recent_albums = DB::table('albums')->join('users', 'users.id', '=', 'albums.artist')->orderBy('albums.created_at', 'desc')->limit(5)->get();
        
        $data = [
            'registered_users_count' => $registered_users_count,
            'active_users_count' => $active_users_count,
            'songs_count' => $songs_count,
            'albums_count' => $albums_count,
            'recent_users' => $recent_users,
            'recent_songs' => $recent_songs,
            'recent_albums' => $recent_albums,
        ];

        return view('home', $data);
    }
}