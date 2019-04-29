<?php

namespace App\Console\Commands;

use App\Models\Man;
use App\Models\ManList;
use App\Service\LogTrait;
use App\Service\Man\App;
use function foo\func;
use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Psr7\Response;
use Illuminate\Console\Command;
use Swoole\Coroutine\Http\Client;
use Swoole\Http\Request;
use Swoole\Runtime;

class ManHan extends Command
{
    use LogTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'manHan';

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
        try {
            $this->logName = $this->signature;
            $app = new App();
            $page = 1;
            while (true) {
                $url = '/booklist/?page=' . $page . '';
                $list = $app->list($url);
                if (count($list) === 0) {
                    break;
                }
                $infoList = $app->info($list);
                $this->saveList($infoList);
                array_walk($infoList, function ($info) use ($app) {
                    $result['list'] = $app->image($info['list']);
                    $result['name'] = $info['name'];
                    $this->saveListImage($result);
                });

                $page++;
            }
        }catch (\Exception $e) {
            $this->logWrite($e->getMessage());
            $this->logWrite($e->getTraceAsString());
        }
    }

    public function saveList($infoList)
    {
        array_walk($infoList, function ($info) {
            $man = Man::query()->updateOrCreate([
                'name' => $info['name']
            ], array_except($info, ['list']));
            $man->save();
            $this->logWrite('name:'.$info['name'].' save success!');
        });
        return true;
    }

    public function saveListImage($data)
    {
        $manId = Man::query()->where('name', $data['name'])->value('id');
        ManList::query()->where('man_id', $manId)->delete();
        $insert = [];
        array_walk($data['list'], function ($list, $key) use ($manId, &$insert) {
            $insert[$key] = [
                'title' => $list['title'],
                'man_id'    => $manId,
                'chapter'   => json_encode($list['image']),
                'insert_at' => date('Y-m-d H:i:s'),
                'update_at' => date('Y-m-d H:i:s'),
            ];
        });
        ManList::query()->insert($insert);
        $this->logWrite('name:'.$data['name'].' chapter num->'.count($insert).' save success!');
    }
}
