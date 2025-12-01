<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Post;

class ArticleStatusUpdated extends Notification
{
    use Queueable;

    public $post;

    // 1. Pass the Post object so we can use the Title and Status
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    // 2. Define Channels (Database AND Email)
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    // 3. Design the Email
    public function toMail(object $notifiable): MailMessage
    {
        $status = ucfirst($this->post->status); // "Published" or "Rejected"
        $color = $this->post->status === 'published' ? 'success' : 'error';

        return (new MailMessage)
                    ->subject("Article Update: {$this->post->title}")
                    ->greeting("Hello {$notifiable->name},")
                    ->line("Your article '{$this->post->title}' has been {$this->post->status}.")
                    ->action('View Dashboard', url('/dashboard'))
                    ->line('Thank you for contributing to PlantsHealth!');
    }

    // 4. Design the Database Alert (Saved as JSON)
    public function toArray(object $notifiable): array
    {
        return [
            'post_id' => $this->post->id,
            'title' => $this->post->title,
            'status' => $this->post->status,
            'message' => "Your article '{$this->post->title}' was {$this->post->status}.",
            'link' => route('posts.show', ['username' => 'author', 'slug' => $this->post->slug]) // Simplified link
        ];
    }
}