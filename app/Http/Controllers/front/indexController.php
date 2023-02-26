<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Comments;
use App\Models\Questions;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index()
    {
        $data = Questions::orderBy('id', 'desc')->paginate(10);
        return view('front.index', ['data' => $data, 'title' => 'Son Sorular']);
    }


    public function cevaplanmis()
    {
        $cevaplanmis = Questions::join('comments', 'questions.id', '=', 'comments.questionId')
            ->select(['questions.*'])
            ->paginate(10);
        return view('front.index', ['data' => $cevaplanmis, 'title' => 'Cevaplanmış Sorular']);
    }

    public function cozumlenmis()
    {
        $cozumlenmis = Questions::join('comments', 'questions.id', '=', 'comments.questionId')
            ->where('comments.isCorrect', 1)
            ->select(['questions.*'])
            ->paginate(10);
        return view('front.index', ['data' => $cozumlenmis, 'title' => 'Çözümlenmiş Sorular']);

    }

    public function view($id, $selflink)
    {
        $c = Questions::where('id', $id)->where('selflink', $selflink)->count();
        if ($c != 0) {
            $data = Questions::where('id', $id)->where('selflink', $selflink)->get();
            $comments = Comments::where('questionId', $id)->orderBy('id', 'desc')->get();
            return view('front.question.view', ['data' => $data, 'comments' => $comments]);
        } else {
            abort(404);
        }
    }
}
