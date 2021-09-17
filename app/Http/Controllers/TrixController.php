<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class TrixController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('trix');
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        if($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName   = pathinfo($originName, PATHINFO_FILENAME);
            $extension  = $request->file('upload')->getClientOriginalExtension();
            $fileName   = $fileName.'_'.time().'.'.$extension;
            $request->file('upload')->move(public_path('images'), $fileName);
            $url = asset('images/'.$fileName);
            return json_encode(['href' => $url, "url"=> $url]);
        }
    }
}
