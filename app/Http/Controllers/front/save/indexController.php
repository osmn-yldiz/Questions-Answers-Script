<?php

namespace App\Http\Controllers\front\save;

use App\Http\Controllers\Controller;
use App\Models\Questions;
use App\Models\SaveQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class indexController extends Controller
{
    public function index()
    {
        $data = SaveQuestion::where('userId', Auth::id())->orderBy('id', 'desc')->paginate(10);
        return view('front.save.index', ['data' => $data]);
    }


    public function store($id)
    {
        $c = Questions::where('id', $id)->count();
        if ($c != 0) {
            $control = SaveQuestion::where('questionId', $id)->where('userId', Auth::id())->count();
            if ($control == 0) {
                SaveQuestion::create(['questionId' => $id, 'userId' => Auth::id()]);
            } else {
                SaveQuestion::where('questionId', $id)->where('userId', Auth::id())->delete();
            }
            return redirect()->back();
        } else {
            abort(404);
        }
    }
}
