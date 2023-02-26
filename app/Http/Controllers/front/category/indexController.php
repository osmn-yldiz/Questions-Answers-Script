<?php

namespace App\Http\Controllers\front\category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Questions;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index($selflink)
    {
        $c = Category::where("selflink", $selflink)->count();

        if ($c != 0) {
            $info = Category::where("selflink", $selflink)->get();
            $data = Questions::leftJoin('questions_categories', 'questions.id', '=', 'questions_categories.questionId')
                ->where('questions_categories.categoryId', $info[0]['id'])
                ->select(['questions.*'])
                ->orderBy('questions.id', 'desc')
                ->paginate(10);

            return view("front.category.index", ['data' => $data, 'info' => $info]);
        } else {
            abort(404);
        }

    }

}
