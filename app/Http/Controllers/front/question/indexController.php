<?php

namespace App\Http\Controllers\front\question;

use App\Helper\mHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comments;
use App\Models\Questions;
use App\Models\QuestionsCategory;
use App\Models\QuestionsTags;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class indexController extends Controller
{

    public function create()
    {
        $category = Category::all();
        return view('front.question.create', ['category' => $category]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'text' => 'required',
            'category' => 'required',
            'tags' => 'required'
        ]);
        $all = $request->except('_token');

        $category = $all['category'];
        unset($all['category']);

        $tags = explode(',', $all['tags']);
        unset($all['tags']);

        $all['userId'] = Auth::id();
        $all['selflink'] = mHelper::permalink($all['title']);

        $create = Questions::create($all);
        if ($create) {

            foreach ($category as $k => $v) {
                QuestionsCategory::create(['questionId' => $create->id, 'categoryId' => $v]);
            }

            foreach ($tags as $k => $v) {
                QuestionsTags::create(['name' => $v, 'selflink' => mHelper::permalink($v), 'questionId' => $create->id]);
            }

            return redirect()->back()->with('status', 'Soru Başarı ile Soruldu :)');

        } else {
            return redirect()->back()->with('status', 'Soru Sorulamadı :/');
        }

    }


    public function edit($id)
    {
        $c = Questions::where('id', $id)->where('userId', Auth::id())->count();
        if ($c != 0) {
            $category = Category::all();
            $data = Questions::where('id', $id)->where('userId', Auth::id())->get();
            return view('front.question.edit', ['data' => $data, 'category' => $category]);
        } else {
            abort(404);
        }
    }


    public function update(Request $request)
    {
        $id = $request->route('id');
        $c = Questions::where('id', $id)->where('userId', Auth::id())->count();
        if ($c != 0) {
            $request->validate([
                'title' => 'required',
                'text' => 'required',
                'category' => 'required',
                'tags' => 'required'
            ]);
            $all = $request->except('_token');
            $category = $all['category'];
            unset($all['category']);

            $tags = $all['tags'];
            unset($all['tags']);

            QuestionsCategory::where('questionId', $id)->delete();
            foreach ($category as $k => $v) {
                QuestionsCategory::create(['questionId' => $id, 'categoryId' => $v]);
            }

            $tagsExplode = explode(',', $tags);
            QuestionsTags::where('questionId', $id)->delete();
            foreach ($tagsExplode as $k => $v) {
                QuestionsTags::create(['questionId' => $id, 'name' => $v, 'selflink' => mHelper::permalink($v)]);
            }

            $all['selflink'] = mHelper::permalink($all['title']);

            Questions::where('id', $id)->update($all);
            return redirect()->back()->with('status', 'Bilgiler Değiştirildi');


        } else {
            abort(404);
        }
    }

    public function delete($id)
    {
        $c = Questions::where('id', $id)->where('userId', Auth::id())->count();
        if ($c != 0) {
            // 1. soruyu sil
            Questions::where('id', $id)->where('userId', Auth::id())->delete();
            // 2. Kategori sil
            QuestionsCategory::where('questionId', $id)->delete();
            // 3. Etiketleri Sil
            QuestionsTags::where('questionId', $id)->delete();
            // 4. Yorumlar
            Comments::where('questionId', $id)->delete();
            //5 görüntülenme sil
            Visitor::where('questionId', $id)->delete();

            return redirect('/');
        } else {
            abort(404);
        }
    }

}
