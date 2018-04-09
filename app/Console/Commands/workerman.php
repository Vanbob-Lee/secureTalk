<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Workerman\Worker;
use Workerman\Autoloader;

class workerman extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'workerman:command {action} {-d}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Workerman Server';

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
     * @return mixed
     */
    public function handle()
    {
        //

        /*
        $ws = new Worker('websocket://0.0.0.0:9011');
        $ws->count = 4;  // 进程数，在windows下无效
        $ws->onConnect = function ($con) {
            echo "new Con\n";
        };
        $ws->onMessage = function ($con, $msg) {
            echo "$msg\n";
            $con->send('hello');
        };
        $ws->onClose = function ($con) {
            echo "Con closed.\n";
        };
        Worker::runAll();
        */

        /*
        $worker = new Worker('websocket://0.0.0.0:8686');

        $worker->onMessage = function($connection, $data)
        {
            $connection->send("hello");
        };

        Worker::runAll();
        */
    }


}
