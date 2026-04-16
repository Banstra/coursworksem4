<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    // 1. Список с пагинацией
    public function index()
    {
        $articles = Article::latest('published_at')->paginate(4); // Пагинация по 4 шт.
        return view('articles.index', compact('articles'));
    }

    // 2. Форма создания (Read View)
    public function create()
    {
        return view('articles.create');
    }

    // 3. Сохранение в БД (Store)
    public function store(Request $request)
    {
        // Валидация
        $validated = $request->validate([
            'name'          => 'required|string|min:3|max:200',
            'published_at'  => 'required|date',
            'short_desc'    => 'nullable|string|max:500',
            'full_text'     => 'required|string',
            'preview_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'full_image'    => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        // Обработка файлов
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

        return redirect()->route('articles.index')
            ->with('success', 'Новость успешно создана');
    }

    // 4. Просмотр одной новости (Show)
    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }

    // 5. Форма редактирования (Edit)
    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    // 6. Обновление данных (Update)
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'name'          => 'required|string|min:3|max:200',
            'published_at'  => 'required|date',
            'short_desc'    => 'nullable|string|max:500',
            'full_text'     => 'required|string',
            'preview_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'full_image'    => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        // Если загружены новые картинки — сохраняем их, старые удаляем
        if ($request->hasFile('preview_image')) {
            // Удаляем старое превью, если оно есть и не является стандартным
            $oldPreview = $article->preview_image;
            if ($oldPreview && !in_array($oldPreview, ['preview.jpg', 'preview_2.jpg'])) {
                $oldPath = public_path('images/' . $oldPreview);
                if (file_exists($oldPath)) unlink($oldPath);
            }
            $filename = time() . '_preview_' . $request->file('preview_image')->getClientOriginalName();
            $request->file('preview_image')->move(public_path('images'), $filename);
            $validated['preview_image'] = $filename;
        }

        if ($request->hasFile('full_image')) {
            $oldFull = $article->full_image;
            if ($oldFull && !in_array($oldFull, ['full.jpeg', 'full_2.jpeg'])) {
                $oldPath = public_path('images/' . $oldFull);
                if (file_exists($oldPath)) unlink($oldPath);
            }
            $filename = time() . '_full_' . $request->file('full_image')->getClientOriginalName();
            $request->file('full_image')->move(public_path('images'), $filename);
            $validated['full_image'] = $filename;
        }

        $article->update($validated);

        return redirect()->route('articles.index')
            ->with('success', 'Новость обновлена');
    }

    // 7. Удаление (Destroy)
    public function destroy(Article $article)
    {
        // Удаляем файлы из public/images/
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
