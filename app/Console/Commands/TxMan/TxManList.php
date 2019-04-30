<?php

namespace App\Console\Commands\TxMan;

use App\Service\Man\TxMan\App;
use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Psr7\Response;
use Illuminate\Console\Command;

class TxManList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'txManList';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $app = new App();
        $url = '/Comic/all/state/pink/search/time/vip/1/page/1';
        $urls = $app->list($url);
    }
}
