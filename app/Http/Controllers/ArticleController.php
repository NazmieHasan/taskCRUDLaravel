<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class ArticleController extends Controller
{
    public function index() {
        return view('article.index');
    }
    
    public function fetchArticle() {
        $articles = Article::orderBy('id', 'DESC')->get();
        return response()->json([
            'articles' => $articles,
        ]);
    }
    
    public function store(Request $request) {
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
            $fileName = rand() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images/articles', $fileName);
            $article->image = $fileName;
            
            $article->price = $request->input('price');
            $article->save();
            return response()->json([
                'status' => 200,
                'message' => 'Article Added Successfully',
            ]);
        }   
    }
    
    
    public function create()
    {
        return view('article.create');
    }

    public function storenew(Request $request)
    {
        $this->validate($request, [
            'name'=>'required|max:120',
            'description'=>'required|max:255',
            'image' => 'required|mimes:jpg,jpeg|max:2048',
            'price' => 'required|numeric|min:0.01|regex:/^\d+(\.\d{1,2})?$/',
        ]);

            $article = new Article;
            $article->name = $request->input('name');
            $article->description = $request->input('description');
            
            $image = $request->file('image');
            $fileName = rand() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images/articles', $fileName);
            $article->image = $fileName;
            
            $article->price = $request->input('price');
            $article->save();
        
        return redirect('/add-articles')->with('status','Inserted Successfully.');
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
                    $fileName = rand() . '.' . $image->getClientOriginalExtension();
                    $path = $image->storeAs('public/images/articles', $fileName);
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
    
    public function searchByNameAndPrice(Request $request) {
    
        $queryMin = "CAST(price AS DECIMAL(10,2)) ASC";
        $minPrice = DB::table('articles')->select('price')->orderByRaw($queryMin)->value('price');
       
        $queryMax = "CAST(price AS DECIMAL(10,2)) DESC";
        $maxPrice = DB::table('articles')->select('price')->orderByRaw($queryMax)->value('price');
        
        $diffPrice = $maxPrice - $minPrice;
        $step = $diffPrice / 10;

        $minPriceDefault = $minPrice + ($step * 3); 
        $maxPriceDefault = $minPrice + ($step * 7);
    
        $name = ''; $articleFinds = ''; 
        $pricefrom = ''; $priceto = ''; 
        
        $name = $request->input('name');
        $pricefrom = $request->input('pricefrom');
        $priceto = $request->input('priceto');
       
        $qb = DB::table('articles');
        
        if ($name) {
            $qb->where('name', 'like', '%'.$name.'%');
        }
        
        if ( ($pricefrom ) && ($priceto) ) {
            $qb->whereBetween('price', [(double)$pricefrom, (double)$priceto]);
        }
        
        if ( ($pricefrom) && (!$priceto) ) {
            $qb->where('price', '>', (double)$pricefrom);
        }
        
        if ( ($priceto) && (!$pricefrom) ) {
            $qb->where('price', '<', (double)$priceto);
        }
        
        $articleFinds = $qb->get();
            
        return view('article.search', [
            'articleFinds' => $articleFinds,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'step' => $step,
            'minPriceDefault' => $minPriceDefault,
            'maxPriceDefault' => $maxPriceDefault,
        ]);    
    }
    
    public function search(Request $request) {
        $output = "";
        
        $articles = Article::where('name', 'like', '%'.$request->search.'%')->get();
        
        foreach($articles as $article) {
            $output .=
            '<tr>
                <td> '.$article->id.' </td>
                <td> '.$article->name.' </td>
                <td> '.$article->description.' </td>
                <td> '.$article->image.' </td>
                <td> '.$article->price.' </td>\
                <td><button type="button" value="'.$article->id.'" class="edit_article btn btn-primary btn-sm">Edit</button</td>
                <td><button type="button" value="'.$article->id.'" class="delete_article btn btn-danger btn-sm">Delete</button</td>
            </tr>';
        }
        
        return response($output);
    }
       
}
