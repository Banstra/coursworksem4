<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Список всех новостей
     */
    public function index()
    {
        $articles = Article::latest('published_at')->paginate(6);
        return view('articles.index', compact('articles'));
    }

    /**
     * Просмотр одной новости
     */
    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }
}
