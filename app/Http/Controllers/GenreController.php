<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
use DataTables;
use Hidehalo\Nanoid\Client;
use Hidehalo\Nanoid\GeneratorInterface;

class GenreController extends Controller
{
    public function index()
    {
        return view('genres');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'genre' => 'required|string',
        ]);

        $client = new Client();

        $newGenre = new Genre;
        $newGenre->id = 'genre-' . $client->generateId($size = 16);
        $newGenre->name = $data['genre'];
        $newGenre->save();

        return redirect('genres');
    }

    public function update(Request $request)
    {
        $id_genre = $request->route('id');

        $data = $request->validate([
            'genreName' => 'required|string',
        ]);

        Genre::where('id', $id_genre)->update(['name' => $data['genreName']]);

        return response()->json(['success' => true]);
    }

    public function delete(Request $request)
    {
        $id_genre = $request->route('id');

        $genre = Genre::find($id_genre);
        $genre->delete();

        return redirect('genres');
    }

    public function getDataTable()
    {
        $data = Genre::select('*')
            ->get();

        return DataTables::of($data)->make(true);
    }
}
