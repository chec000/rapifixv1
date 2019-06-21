<?php

namespace Modules\Admin\Notifications;

use Modules\Admin\Entities\ACL\User;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PasswordReset extends Notification
{

    /**
     * @var User
     */
    protected $_user;

    /**
     * @var string
     */
    protected $_routeName;

    /**
     * PasswordReset constructor.
     * @param User $user
     * @param string $routeName
     */
    public function __construct($user, $routeName)
    {
        $this->_user = $user;
        $this->_routeName = $routeName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(config('cms.site.name') . ': Forgotten Password')
            ->from(config('cms.site.email'))
            ->line(trans('admin::emailForgotPassword.intro_lines'))
            ->action(trans('admin::emailForgotPassword.action_button'), url(route($this->_routeName, $this->_user->tmp_code)))
            ->line(trans('admin::emailForgotPassword.outro_lines'));
    }

}
