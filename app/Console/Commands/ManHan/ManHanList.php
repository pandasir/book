<?php

namespace App\Console\Commands\ManHan;

use App\Models\Man;
use App\Models\ManDetail;
use App\Models\ManHan;
use App\Service\LogTrait;
use App\Service\Man\ManHan\App;
use Illuminate\Console\Command;

class ManHanList extends Command
{
    use LogTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'manHanList';

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
                $page++;
            }
            $this->measureTime();

        }catch (\Exception $exception) {
            $this->logWrite($exception->getMessage());
            $this->logWrite($exception->getTraceAsString());
        }
    }

    public function saveList($infoList)
    {
        array_walk($infoList, function ($info) {
            $man = Man::query()->updateOrCreate([
                'name' => $info['name']
            ], array_except($info, ['list', 'url']));
            $man->save();

            $manHan = ManDetail::query()->updateOrCreate([
                'man_id' => $man->id,
            ], [
                'url'           => $info['url'],
                'platform_id'   => 1,
                'chapter_url'   => json_encode($info['list'])
            ]);
            $manHan->save();
            $this->logWrite('name:'.$info['name'].' save success!');
        });
        return true;
    }
}
