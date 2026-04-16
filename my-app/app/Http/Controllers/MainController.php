<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $jsonPath = database_path('articles.json');
        $articles = json_decode(file_get_contents($jsonPath), true);

        return view('welcome', compact('articles'));
    }

    public function gallery($imageName)
    {
        $jsonPath = database_path('articles.json');
        $articles = json_decode(file_get_contents($jsonPath), true);

        $article = collect($articles)->firstWhere('full_image', $imageName);

        return view('gallery', compact('article'));
    }
}
