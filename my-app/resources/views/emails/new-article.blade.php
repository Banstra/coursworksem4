<x-mail::message>
    # 📰 Новая статья добавлена

    Здравствуйте, **{{ $moderatorName }}**!

    Пользователь **{{ $userName ?? 'Система' }}** добавил новую статью:

    ## {{ $article->name }}

    <x-mail::panel>
        📅 **Дата публикации:** {{ $article->published_at->format('d.m.Y') }}

        @if($article->short_desc)
            📝 **Краткое описание:** {{ $article->short_desc }}
        @endif
    </x-mail::panel>

    {{-- ✅ Изображение через обычный HTML --}}
    @if($article->preview_image)
        <div style="text-align: center; margin: 20px 0;">
            <img src="{{ url('images/' . $article->preview_image) }}"
                 alt="{{ $article->name }}"
                 style="max-width: 100%; height: auto; border-radius: 4px;">
        </div>
    @endif

    <x-mail::button :url="url('/articles/' . $article->id)">
        👁️ Просмотреть статью
    </x-mail::button>

    @if($article->full_text)
        ---
        ### Полный текст:
        {{ \Str::limit($article->full_text, 300) }}
    @endif

    ---
    <small>Это письмо отправлено автоматически. Не отвечайте на него.</small>

    <x-mail::footer>
        © {{ date('Y') }} {{ config('app.name') }}. Все права защищены.
    </x-mail::footer>
</x-mail::message>
