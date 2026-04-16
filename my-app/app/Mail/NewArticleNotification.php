<?php

namespace App\Mail;

use App\Models\Article;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue; // ← Правильный импорт!
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewArticleNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Article $article,
        public User $moderator
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '📰 Новая статья: ' . $this->article->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.new-article',
            with: [
                'article' => $this->article,
                'moderatorName' => $this->moderator->name,
                'articleUrl' => route('articles.show', $this->article, absolute: false),
            ],
        );
    }
}
