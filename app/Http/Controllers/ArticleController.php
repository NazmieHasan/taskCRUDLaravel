<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function index() {
        return view('article.index');
    }
    
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:191',
            'description' => 'required|max:191',
            'image' => 'required|max:191',
            'price' => 'required|max:191',
        ]);
    
        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $article = new Article;
            $article->name = $request->input('name');
            $article->description = $request->input('description');
            $article->image = $request->input('image');
            $article->price = $request->input('price');
            $article->save();
            return response()->json([
                'status' => 200,
                'message' => 'Article Added Successfully',
            ]);
        }   
    }
    
}