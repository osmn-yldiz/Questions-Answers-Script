<?php

namespace App\Http\Controllers\front\settings;

use App\Helper\fileUpload;
use App\Http\Controllers\Controller;
use App\Models\Notifications;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class indexController extends Controller
{
    public function index()
    {
        return view('front.settings.index');
    }

    public function store(Request $request)
    {
        $request->validate(['first_name' => 'required', 'last_name' => 'required', 'birthdate' => 'required', 'email' => 'required']);
        $all = $request->except('_token');
        $c = User::where('email', $all['email'])->where('id', '!=', Auth::id())->count();
        if ($c != 0) {
            return redirect()->back()->with('status', 'Bu Email Sistemde Mevcut');
        }

        $data = User::where('id', Auth::id())->get();
        $all['photo'] = fileUpload::changeUpload(Auth::id(), "user", $request->file('photo'), 0, $data, "photo");
        $update = User::where('id', Auth::id())->update($all);
        if ($update) {
            return redirect()->back()->with('status', 'Ayarlar Değiştirildi');
        } else {
            return redirect()->back()->with('status', 'Ayarlar Değiştirilemedi');
        }

    }

    public function password()
    {
        return view('front.settings.password');
    }

    public function passwordStore(Request $request)
    {
        $request->validate(['currentpassword' => 'required', 'password' => 'required', 'retrypassword' => 'required']);

        $all = $request->except('_token');

        if (md5($all['currentpassword']) == Auth::user()->password) {
            if ($all['password'] == $all['retrypassword']) {
                User::where('id', Auth::id())->update(['password' => md5($all['password'])]);
                return redirect()->back()->with('status', 'Şifre Değiştirildi');
            } else {
                return redirect()->back()->with('status', 'Şifreler Uyumsuz');
            }
        } else {
            return redirect()->back()->with('status', 'Mevcut Şifre Hatalı');
        }

    }

    public function notifications()
    {
        $data = Notifications::where('receiverUserId', Auth::id())->orderBy('id', 'desc')->paginate(10);
        Notifications::where('receiverUserId', Auth::id())->update(['isRead' => 0]);
        return view('front.settings.notifications', ['data' => $data]);
    }
}
