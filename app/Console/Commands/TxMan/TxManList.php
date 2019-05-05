<?php

namespace App\Console\Commands\TxMan;

use App\Models\Man;
use App\Models\ManDetail;
use App\Service\LogTrait;
use App\Service\Man\TxMan\App;
use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Psr7\Response;
use Illuminate\Console\Command;

class TxManList extends Command
{
    use LogTrait;

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
        try{
            $this->measureTime();
            $this->logName = $this->signature;
            $app    = new App();
            $page   = 1;
            while ( true ) {
                $url = '/Comic/all/state/pink/search/time/vip/1/page/'.$page.'';
                $urls = $app->list($url);
                $data = $app->info($urls);
                if( !$data ) {
                    break;
                }
                $this->saveList($data);
                $page++;
            }
            $this->measureTime();
        }catch (\Exception $exception){
            $this->logWrite($exception->getMessage());
            $this->logWrite($exception->getTraceAsString());
        }
    }

    public function saveList($infoList)
    {
        array_walk($infoList, function ($info) {
            $info['class'] = '';
            $man = Man::query()->updateOrCreate([
                'name' => $info['name']
            ], array_except($info, ['list', 'url']));
            $man->save();

            $manDetail = ManDetail::query()->updateOrCreate([
                'man_id'        => $man->id,
                'platform_id'   => 2,
            ], [
                'url'           => $info['url'],
                'platform_id'   => 2,
                'chapter_url'   => json_encode($info['list'])
            ]);
            $manDetail->save();
            $this->logWrite('name:'.$info['name'].' save success!');
        });
        return true;
    }
}
