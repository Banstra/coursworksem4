<?php

namespace App\Jobs;

use App\Mail\NewArticleNotification;
use App\Models\Article;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class VeryLongJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 120; // Таймаут выполнения в секундах
    public $tries = 3;     // Количество попыток при ошибке

    public function __construct(
        public Article $article,
        public User $moderator
    ) {}

    /**
     * Выполнение задания
     */
    public function handle(): void
    {
        // 📧 Отправка письма (теперь выполняется в фоне)
        Mail::to($this->moderator->email)->send(
            new NewArticleNotification($this->article, $this->moderator)
        );

        // Опционально: логирование
        \Log::info("✅ Email sent via queue to {$this->moderator->email} for article #{$this->article->id}");
    }

    /**
     * Обработка сбоя задания
     */
    public function failed(\Throwable $e): void
    {
        \Log::error("❌ VeryLongJob failed: " . $e->getMessage(), [
            'article_id' => $this->article->id,
            'moderator_id' => $this->moderator->id,
        ]);
    }
}
