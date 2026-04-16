<x-mail::message>
    # 📰 Новая статья добавлена

    Здравствуйте, **{{ $moderatorName }}**!

    Пользователь **{{ Auth::user()?->name ?? 'Система' }}** добавил новую статью:

    ## {{ $article->name }}

    <x-mail::panel>
        📅 **Дата публикации:** {{ $article->published_at->format('d.m.Y') }}

        @if($article->short_desc)
            📝 **Краткое описание:** {{ $article->short_desc }}
        @endif
    </x-mail::panel>

    @if($article->preview_image)
        <x-mail::image src="{{ asset('images/' . $article->preview_image) }}" alt="{{ $article->name }}" />
    @endif

    <x-mail::button :url="$articleUrl">
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
