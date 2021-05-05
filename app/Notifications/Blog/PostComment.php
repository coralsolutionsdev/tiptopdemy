<?php

namespace App\Notifications\Blog;

use App\BlogPost;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostComment extends Notification
{
    use Queueable;

    public $post;
    private $commenter;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, BlogPost $post)
    {
        $this->commenter = $user;
        $this->post = $post;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
//        return ['mail'];
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'notifier_id' =>  $this->commenter->id,
            'notifier_name' =>  $this->commenter->first_name.' '.$this->commenter->last_name,
            'notifier_image' =>  $this->commenter->getProfilePicURL(),
            'notifiable_user_id' =>  $this->post->user_id,
            'message' => 'has commented on your post',
            'description' => $this->post->title,
            'model_id' =>  $this->post->id,
            'model_type' =>  $this->post->getClassName(),
            'action_url' =>  route('blog.posts.show', $this->post->slug),
        ];
    }
}
