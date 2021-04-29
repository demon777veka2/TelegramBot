<?php

namespace App\Console\Commands;

use App\Services\MessageService;
use GuzzleHttp\Psr7\Message;
use Illuminate\Console\Command;

class getMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Получения новых сообщений';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {   
        $message = new MessageService();
        $message->getMessages();
      //  dd($message->sendMessage(,qwq));
        return 0;
    }
}
