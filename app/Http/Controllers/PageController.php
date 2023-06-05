<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleComment;
use App\Models\ArticleLike;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{

    public function detail($slug)
    {
        $article=Article::where('slug',$slug)
        ->withCount('like','comment')
        ->with('category','language','comment.user')
        ->first();
        return view('detail',compact('article'));
    }

    public function index(Request $request)
    {
        if(isset($request->search))
        {
            $search=$request->search;
            $articles=Article::withCount('like','comment')
            ->where('title','like',"%{$search}%")
            ->latest()
            ->paginate(6);
            $articles->appends($request->all());
        } else {
            $articles=Article::withCount('like','comment')->latest()->paginate(6);
        }

        return view('index',compact('articles'));
    }

    public function articleByCategory(Request $request,$slug)
    {
        $category_id=Category::where('slug',$slug)->first()->id;
        $articles=Article::withCount('like','comment')
        ->where('category_id',$category_id)
        ->paginate(6);
        return view('index',compact('articles'));
    }


    public function articleByLanguage(Request $request,$slug)
    {
        $language_id=Language::where('slug',$slug)->first()->id;
        $articles=Article::withCount('like','comment')
        ->whereHas("language",function($q) use ($language_id)
        {
            $q->where('language_id',$language_id);
        })
        ->paginate(6);
        return view('index',compact('articles'));
    }

    public function createArticle()
    {
        $cat=Category::all();
        $lang=Language::all();

        return view('create',compact('cat','lang'));
    }

    public function postArticle(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'category_id'=>'required',
            'article'=>'required',
            'image'=>'required',
        ]);

        $file=$request->file('image');
        $file_name=uniqid(time()). $file->getClientOriginalName();
        $full_path='image/'.$file_name;
        $file->storeAs('image',$file_name);

        $a=Article::create([
            'user_id'=>Auth::user()->id,
            'category_id'=>$request->category_id,
            'title'=>$request->title,
            'slug'=>uniqid(time()).Str::slug($request->title),
            'image'=>$full_path,
            'description'=>$request->article,
        ]);
        Article::find($a->id)->language()->sync($request->language);
        return redirect()->back()->with('success','Article Created Success!');




    }

    public function createLike($id)
    {
        $user_id=Auth::user()->id;
        ArticleLike::create([
            'user_id'=>$user_id,
            'article_id'=>$id,
        ]);
        $like_count=ArticleLike::where('article_id',$id)->count();
        return response()->json(['data'=>$like_count]);
    }

    public function createComment(Request $request)
    {
        $comment=$request->comment;
        $article_id=$request->article_id;

        ArticleComment::create([
            'user_id'=>Auth::user()->id,
            'article_id'=>$article_id,
            'comment'=>$comment
        ]);
        $comments=ArticleComment::where('article_id',$article_id)->with('user')->get();
        $data="";

        foreach($comments as $c)
        {
            $data.="
            <div class='card-dark mt-1'>
               <div class='card-body'>
                       <div class='row'>
                               <div class='col-md-1'>
                                       <img src='{asset($c->user->image)}'
                                               style='width:50px;border-radius:50%'
                                               alt=''>
                               </div>
                               <div
                                       class='col-md-4 d-flex align-items-center'>
                                       {$c->user->name}
                               </div>
                       </div>
                       <hr>
                       <p>{$c->comment}</p>
               </div>
            </div>
            ";
        }
        return response()->json(['data'=>$data]);
    }

}


