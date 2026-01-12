<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\CheckRequest;
use Illuminate\Support\Facades\Validator;

class CheckJsonRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->isMethod('get')){
            return $next($request);
        }
        $checkRequest=new CheckRequest;
        $validator=Validator::make($request->input(),$checkRequest->rules());
        if($validator->fails()){
            return response()->json((object)["response"=>0,"data"=>["error"=>"Incorrect request fields"]]);
        }
        return $next($request);
    }
}
