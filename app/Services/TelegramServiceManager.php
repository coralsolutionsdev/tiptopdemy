<?php

namespace App\Services;

use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramServiceManager
{
	private $message;

	public function __construct()
	{
	}

	public static function getInstance()
	{
		$instance = new self();
		return $instance;
	}


	public function setMessage($message)
	{
		$this->message_ar = $message;
		return $this;
	}

	public function getMessage()
	{
		return  $this->message_ar ;
	}

	public function send()
	{
//        $act =  Telegram::getUpdates();
//        dd($act);
		return Telegram::sendMessage([
			'chat_id' => config('telegram.bots.mybot.default_channel_id'),
			'parse_mode' => 'HTML',
			'text' => $this->getMessage()
		]);

	}


}
