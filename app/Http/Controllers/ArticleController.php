<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class ArticleController extends Controller
{
    public function index() {
        return view('index');
    }
    
    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:120',
            'description' => 'required|max:255',
            'image' => 'required','mimes:jpg,jpeg','max:2048',
            'price' => 'required|numeric|min:0.01|regex:/^\d+(\.\d{1,2})?$/',
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
            
            $image = $request->file('image');
            $fileName = md5($image->getClientOriginalName() . time()) . "." . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/articles');
            $image->move($destinationPath, $fileName);
            $article->image = $fileName;
            
            $article->price = $request->input('price');
            $article->save();
            return response()->json([
                'status' => 200,
                'message' => 'Article Added Successfully',
            ]);
        }   
    }
    
    public function fetchArticle() {
        $articles = Article::orderBy('id', 'DESC')->get();
        return response()->json([
            'articles' => $articles,
        ]);
    }
    
    public function edit($id) {
        $article = Article::find($id);  
        if($article) {
             return response()->json([
                'status' => 200,
                'article' => $article,
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Article Not Found',
            ]);
        } 
    }
    
    public function update(Request $request, $id) {
    
        $image_name = $request->hidden_image;
        $image = $request->file('image');
        
        if ($image != '') {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:120',
                'description' => 'required|max:255',
                'image' => 'required','mimes:jpg,jpeg','max:2048',
                'price' => 'required|numeric|min:0.01|regex:/^\d+(\.\d{1,2})?$/',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:120',
                'description' => 'required|max:255',
                'price' => 'required|numeric|min:0.01|regex:/^\d+(\.\d{1,2})?$/',
            ]);
        }
        
        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $article = Article::find($id);
            if($article) {
                $article->name = $request->input('name');
                $article->description = $request->input('description');
                
                if($image != '') {
                    $fileName = md5($image->getClientOriginalName() . time()) . "." . $image->getClientOriginalExtension();
                    $destinationPath = public_path('/images/articles');
                    $image->move($destinationPath, $fileName);
                    $article->image = $fileName;
                }
            
                $article->price = $request->input('price');
                $article->update();
                return response()->json([
                    'status' => 200,
                    'message' => 'Article Updated Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Article Not Found',
                ]);
            } 
        }
       
    }
    
    public function destroy($id) {
        $article = Article::find($id);
        $article->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Article Deleted Successfully',
        ]);
    }
    
    public function customValuesSlider() {
    
        $queryMin = "CAST(price AS DECIMAL(10,2)) ASC";
        $min = DB::table('articles')->select('price')->orderByRaw($queryMin)->value('price');
        $min = floor($min);
       
        $queryMax = "CAST(price AS DECIMAL(10,2)) DESC";
        $max = DB::table('articles')->select('price')->orderByRaw($queryMax)->value('price');
        $max = ceil($max);
        
        $diffPrice = $max - $min;
        $step = $diffPrice / 10;
        $step = ceil($step);
        
        $minDefault = $min + ($step * 3); 
        $maxDefault = $min + ($step * 7);
        
        $max = $min + ($step * 10);
        
        return response()->json([
            'min' => $min,
            'max' => $max,
            'step' => $step,
            'minDefault' => $minDefault,
            'maxDefault' => $maxDefault,
        ]);

    }
    
    public function search(Request $request) {
        $output = "";
      
        $name = $request->name;
        $minPrice = (int)$request->startPrice;
        $maxPrice= (int)$request->endPrice;
            
        $articles = Article::where('name', 'like', '%'.$name.'%')->where('price', '>=', $minPrice)->where('price', '<=', $maxPrice)->get(); 
            
        foreach($articles as $article) {
            $output .=
            '<tr>
                <td> '.$article->id.' </td>
                <td> '.$article->name.' </td>
                <td> '.$article->description.' </td>\
                <td><img src="/images/articles/'.$article->image.'" class="img-thumbnail border-0" alt="article image" /></td>
                <td> '.$article->price.' </td>\
                <td><button type="button" value="'.$article->id.'" class="edit_article btn btn-primary btn-sm">Edit</button</td>
                <td><button type="button" value="'.$article->id.'" class="delete_article btn btn-danger btn-sm">Delete</button</td>
            </tr>';
        }  
        
        return response($output);  
    }
       
}
