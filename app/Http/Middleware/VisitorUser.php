<?php

namespace App\Http\Middleware;

use App\Models\Questions;
use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisitorUser
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $id = $request->segment(1);
            $control = Questions::where('id', $id)->count();
            if ($control != 0) {
                $c = Visitor::where('questionId', $id)->where('userId', Auth::id())->count();
                if ($c == 0) {
                    Visitor::create(['questionId' => $id, 'userId' => Auth::id()]);
                }
            }
        }
        return $next($request);
    }
}
