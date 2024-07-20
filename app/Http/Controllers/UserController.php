<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Support\Facades\Mail;
use App\Mail\Mailer;

class UserController extends Controller
{
    public function index()
    {
        return view('user');
    }

    public function detail(Request $request)
    {
        $user_id = $request->route('id');

        $user_detail = User::where('id', $user_id)->first();

        $data = [
            'user_detail' => $user_detail,
        ];

        return view('user-detail', $data);
    }

    public function delete(Request $request)
    {
        $user_id = $request->route('id');

        $is_user_active = User::where('id', $user_id)->select('is_active')->first();

        if ($is_user_active->is_active) {
            return redirect('users/detail/' . $user_id);
        }

        $user = User::find($user_id);
        $user->delete();

        return redirect('users');
    }

    public function logoutAllUsers()
    {
        DB::table('authentications')->truncate();

        return redirect('users')->with('message', 'All users logged out!');
    }

    public function activateUser(Request $request)
    {
        $user_id = $request->route('id');

        $is_user_active = User::where('id', $user_id)->select('is_active')->first();

        if ($is_user_active->is_active) {
            User::where('id', $user_id)->update(['is_active' => false]);
        } else {
            User::where('id', $user_id)->update(['is_active' => true]);
        }

        return response()->json(['success' => true]);
    }

    public function banUser(Request $request)
    {
        $user_id = $request->route('id');

        $is_user_banned = User::where('id', $user_id)->select('is_banned')->first();

        if ($is_user_banned->is_banned) {
            User::where('id', $user_id)->update(['is_banned' => false]);
        } else {
            User::where('id', $user_id)->update(['is_banned' => true]);
        }

        return response()->json(['success' => true]);
    }

    public function notifyUser(Request $request)
    {
        $user_id = $request->route('id');

        $user_email = User::where('id', $user_id)->select('email')->first();

        $data = $request->validate([
            'subject' => 'required|string',
            'content' => 'required|string',
        ]);

        $details = [
            'title' => $data['subject'],
            'body' => $data['content']
        ];

        Mail::to($user_email->email)->send(new Mailer($details));

        return redirect('users/detail/' . $user_id);
    }

    public function getDataTable()
    {
        $data = DB::table('users')->get();

        return DataTables::of($data)->make(true);
    }
}
