<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionsCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    static function getCount($categoryId)
    {
        return QuestionsCategory::where('categoryId', $categoryId)->count();
    }

    static function isChecked($categoryId, $questionId)
    {
        $c = QuestionsCategory::where('categoryId', $categoryId)->where('questionId', $questionId)->count();
        if ($c != 0) {
            return true;
        } else {
            return false;
        }
    }

    static function getCategoryList($questionId)
    {
        return Category::leftJoin('questions_categories', 'questions_categories.categoryId', '=', 'categories.id')
            ->where('questions_categories.questionId', $questionId)
            ->select(['categories.*'])
            ->get();
    }
}
