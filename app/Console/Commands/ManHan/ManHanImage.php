<?php

namespace App\Console\Commands\ManHan;

use App\Models\Man;
use App\Models\ManList;
use App\Service\LogTrait;
use App\Service\Man\ManHan\App;
use Illuminate\Console\Command;

class ManHanImage extends Command
{
    use LogTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'manHanImage';

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
            $this->logName = $this->signature;
            $app = new App();
            \App\Models\ManDetail::query()
                ->select('man_id', 'chapter_url')
                ->where('platform_id', 1)
                ->chunk(1, function ($result) use ($app) {
                    $result = $result->toArray();
                    $urls   = collect($result)->pluck('chapter_url')->map(function ($val) {
                        return json_decode($val, true);
                    })->collapse()->toArray();
                    $manId = current($result)['man_id'];
                    $imageList = $app->image($urls);
                    $this->saveListImage($imageList, $manId);
                });
        }catch (\Exception $e) {
            $this->logWrite($e->getMessage());
            $this->logWrite($e->getTraceAsString());
        }
    }

    public function saveListImage($data, $manId)
    {
        $insert = [];
        ManList::query()
            ->where('man_id', $manId)
            ->where('platform_id', 1)
            ->delete();
        array_walk($data, function ($list, $key) use ($manId, &$insert) {
            $insert[$key] = [
                'title'         => $list['title'],
                'man_id'        => $manId,
                'image_url'     => json_encode($list['image']),
                'platform_id'   => 1,
                'sort'          => $list['sort'],
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ];
        });
        ManList::query()->insert($insert);
        $this->logWrite('man_id:'.$manId.' chapter num->'.count($insert).' save success!');
    }
}
