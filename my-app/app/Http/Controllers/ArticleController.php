<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller // Убедитесь, что расширяете базовый Controller
{
    public function index()
    {
        // viewAny разрешён всем — проверка не нужна
        $articles = Article::latest('published_at')->paginate(4);
        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        $this->authorize('create', Article::class); // ← Ручная проверка
        return view('articles.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Article::class); // ← Ручная проверка

        $validated = $request->validate([
            'name' => 'required|string|min:3|max:200',
            'published_at' => 'required|date',
            'short_desc' => 'nullable|string|max:500',
            'full_text' => 'required|string',
            'preview_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'full_image' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        $data = $validated;
        if ($request->hasFile('preview_image')) {
            $filename = time() . '_preview_' . $request->file('preview_image')->getClientOriginalName();
            $request->file('preview_image')->move(public_path('images'), $filename);
            $data['preview_image'] = $filename;
        }
        if ($request->hasFile('full_image')) {
            $filename = time() . '_full_' . $request->file('full_image')->getClientOriginalName();
            $request->file('full_image')->move(public_path('images'), $filename);
            $data['full_image'] = $filename;
        }

        Article::create($data);
        return redirect()->route('articles.index')->with('success', 'Новость создана');
    }

    public function show(Article $article)
    {
        $this->authorize('view', $article);
        return view('articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        $this->authorize('update', $article);
        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $this->authorize('update', $article);

        $validated = $request->validate([
            'name' => 'required|string|min:3|max:200',
            'published_at' => 'required|date',
            'short_desc' => 'nullable|string|max:500',
            'full_text' => 'required|string',
            'preview_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'full_image' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        if ($request->hasFile('preview_image')) {
            if ($article->preview_image && !in_array($article->preview_image, ['preview.jpg', 'preview_2.jpg'])) {
                $oldPath = public_path('images/' . $article->preview_image);
                if (file_exists($oldPath)) unlink($oldPath);
            }
            $filename = time() . '_preview_' . $request->file('preview_image')->getClientOriginalName();
            $request->file('preview_image')->move(public_path('images'), $filename);
            $validated['preview_image'] = $filename;
        }

        if ($request->hasFile('full_image')) {
            if ($article->full_image && !in_array($article->full_image, ['full.jpeg', 'full_2.jpeg'])) {
                $oldPath = public_path('images/' . $article->full_image);
                if (file_exists($oldPath)) unlink($oldPath);
            }
            $filename = time() . '_full_' . $request->file('full_image')->getClientOriginalName();
            $request->file('full_image')->move(public_path('images'), $filename);
            $validated['full_image'] = $filename;
        }

        $article->update($validated);
        return redirect()->route('articles.index')->with('success', 'Новость обновлена');
    }

    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);

        if ($article->preview_image && !in_array($article->preview_image, ['preview.jpg', 'preview_2.jpg'])) {
            $path = public_path('images/' . $article->preview_image);
            if (file_exists($path)) unlink($path);
        }
        if ($article->full_image && !in_array($article->full_image, ['full.jpeg', 'full_2.jpeg'])) {
            $path = public_path('images/' . $article->full_image);
            if (file_exists($path)) unlink($path);
        }

        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Новость удалена');
    }
}
