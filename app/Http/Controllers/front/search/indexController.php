<?php

namespace App\Http\Controllers\front\search;

use App\Http\Controllers\Controller;
use App\Models\Questions;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index()
    {
        if (isset($_GET['q'])) {
            $q = strip_tags($_GET['q']);
            $data = Questions::where('title', 'like', '%' . $q . '%')->orderBy('id', 'desc')->paginate(10);
            return view('front.search.index', ['data' => $data, 'q' => $q]);


        } else {
            return redirect('/');
        }
    }
}
