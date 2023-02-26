<?php

namespace App\Http\Controllers\front\tags;

use App\Http\Controllers\Controller;
use App\Models\Questions;
use App\Models\QuestionsTags;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index()
    {

        $data = QuestionsTags::groupBy('name')->paginate(20);
        return view('front.tags.index', ['data' => $data]);
    }

    public function view($selflink)
    {
        $c = QuestionsTags::where('selflink', $selflink)->count();
        if ($c != 0) {
            $w = QuestionsTags::where('selflink', $selflink)->get();
            $data = Questions::leftJoin('questions_tags', 'questions.id', '=', 'questions_tags.questionId')
                ->where('questions_tags.selflink', $selflink)
                ->select(['questions.*'])
                ->paginate(10);

            return view('front.index', ['data' => $data, 'title' => $w[0]['name']]);
        } else {
            abort(404);
        }
    }
}
