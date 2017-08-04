<?php

namespace Bot\Telegram;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */

defined("TOKEN") or require __DIR__."/../../../config/telegram.php";

use Bot\Telegram\Traits\Command;
use Bot\Telegram\Traits\CommandHandler;

class Bot
{
	use Command;
	use CommandHandler;

	/**
	 * @var array
	 */
	private $input;

	/**
	 * @var string
	 */
	private $msg_type;

	/**
	 * Run bot.
	 * @param string $argv
	 */
	public function run($arg)
	{
		$this->input = json_decode($arg, true);
		$this->parseEvent();
		if ($this->msg_type == "text") {
			$this->textFixer();
			if (!$this->command()) {

			}
		}
	}

	/**
	 * Parse webhook event.
	 */
	private function parseEvent()
	{
		if (isset($this->input['message']['text'])) {
			$this->msg_type = "text";
			$this->text = $this->input['message']['text'];
			$this->room_id = $this->input['message']['chat']['id'];
			$this->user_id = $this->input['message']['from']['id'];
			$this->uname = isset($this->input['message']['from']['username']) ? $this->input['message']['from']['username'] : null;
			$this->actor = $this->input['message']['from']['first_name']. (isset($this->input['message']['from']['last_name']) ? " ".$this->input['message']['from']['last_name'] : "");
			$this->actor_call = $this->input['message']['from']['first_name'];
			$this->chat_type = $this->input['message']['chat']['type'];
			$this->msg_id = $this->input['message']['message_id'];
		}
	}

	/**
	 * Text fixer.
	 */
	private function textFixer()
	{
		$sbt = substr($this->text, 0, 4);
		if ($sbt == "ask " || $sbt == "ask\n") {
			$this->text = "/".$this->text;
		}
	}
}