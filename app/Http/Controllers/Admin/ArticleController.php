<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Article\StoreUpdateArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ArticleController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Article/Index', [
            'categories' => Category::all(),
            'articles' => Article::with(['images'])->get(),
        ]);
    }

    public function show(Request $request, $language, Article $article): Article
    {
        return $article->load('images');
    }

    public function store(StoreUpdateArticleRequest $request)
    {
        $data = $request->safe()->except(['images']);
        $article = Article::query()->create($data);

        if ($request->images != []) {
            ImageService::store(
                temporary_images: $request->images,
                disk: 'articles_image',
                foreign_key: 'article_id',
                foreign_key_value: $article->id
            );
        }

        return Redirect::route('admin.articles.index', $request->language)->with('success', 'Success');
    }

    public function update(StoreUpdateArticleRequest $request, $language, Article $article)
    {
        $data = $request->safe()->except(['images']);
        $article->update($data);

        if ($request->images != []) {
            ImageService::store(
                temporary_images: $request->images,
                disk: 'articles_image',
                foreign_key: 'article_id',
                foreign_key_value: $article->id
            );
        }

        return Redirect::route('admin.articles.index', $language)->with('success', 'Success');
    }

    public function destroy(Request $request, $language, Article $article)
    {
        Storage::disk('articles_image')->deleteDirectory($article->id);

        $article->delete();
//        Article::destroy($article->id);

        return Redirect::route('admin.articles.index', $language)->with('success', 'Success');
    }
}
