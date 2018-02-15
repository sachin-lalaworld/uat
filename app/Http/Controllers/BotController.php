<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Longman\TelegramBot\Telegram;

use Longman\TelegramBot\Exception\TelegramException;


class BotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $bot_id     = '';

    private $bot_uname  = '';

    private $bot_name   = '';

    private $bot_token  = '';

    private $command    = [];

    private $comm_path  = '';

    public function __construct()
    {

        $this->bot_id       = env('BOT_ID');

        $this->bot_uname    = env('BOT_USER_NAME');

        $this->bot_name     = env('BOT_NAME');

        $this->bot_token    = env('BOT_TOKEN');

        $this->hook_url     = 'https://uat.lalaworld.io/telegram/hook';

        $this->comm_path    = realpath(__DIR__ . DIRECTORY_SEPARATOR . '../../..').'/vendor/longman/telegram-bot/src';

        $this->command      = [

            $this->comm_path.'/Commands',

            $this->comm_path.'/Commands/AdminCommands',

            $this->comm_path.'/Commands/UserCommands',

            $this->comm_path.'/Commands/SystemCommands'
        
        ];

    }

    public function hook()
    {

        try {

           // Create Telegram API object
            $telegram = new Telegram($this->bot_token, $this->bot_uname);

            $telegram->addCommandsPaths($this->command);

            $telegram->enableLimiter();

            $result = $telegram->handle();

        } catch (TelegramException $e) {
            
            dd($e->getMessage());
        }

        dd($result);
    }

    public function run()
    {

        try {

           // Create Telegram API object
            $telegram = new Telegram($this->bot_token, $this->bot_uname);

            $telegram->addCommandsPaths($this->command);

            $result = $telegram->runCommands(['/start']);

            dd($result);

        } catch (TelegramException $e) {
            
            dd($e->getMessage());
        }

        dd($result);

    }
        
    public function set()
    {

        try {
            // Create Telegram API object
            $telegram = new Telegram($this->bot_token, $this->bot_uname);

            // Set webhook
            $result = $telegram->setWebhook($this->hook_url,['certificate'=>'/etc/ssl/certs/ca-certificates.crt']);

            if ($result->isOk()) {

                $response = $result->getDescription();

            }else{

                $response = '';
            }

        } catch (TelegramException $e) {
            
            dd($e->getMessage());
        }

        dd($response);
    }

    public function unset()
    {
        try {
            // Create Telegram API object
            $telegram = new Longman\TelegramBot\Telegram($bot_api_key, $bot_username);
            // Delete webhook
            $result = $telegram->deleteWebhook();
            if ($result->isOk()) {

                $response = $result->getDescription();

            }else{

                $response = '';
            }
        } catch (Longman\TelegramBot\Exception\TelegramException $e) {
            dd($e->getMessage());
        }

        dd($response);
    }

}
