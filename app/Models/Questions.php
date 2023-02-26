<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    use HasFactory;

    protected $guarded = [];

    static function getSelflink($questionId)
    {
        $data = Questions::where('id', $questionId)->get();
        return $data[0]['selflink'];
    }

    static function getTitle($questionId)
    {
        $data = Questions::where('id', $questionId)->get();
        return $data[0]['title'];
    }

    static function likeQuestions($questionId)
    {
        $getQuestionsCategory = QuestionsCategory::where('questionId', $questionId)->get();


        $data = Questions::leftJoin('questions_categories', 'questions.id', '=', 'questions_categories.questionId')
            ->where('questions.id', '!=', $questionId)
            ->where(function ($data) use ($getQuestionsCategory) {
                foreach ($getQuestionsCategory as $k => $v) {
                    $data->orWhere('questions_categories.categoryId', $v['categoryId']);
                }
            });
        $data = $data->select(['questions.*'])->orderBy('id', 'desc')->limit(5)->get();
        return $data;
    }
}
