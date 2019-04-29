<?php

namespace App\Console\Commands\ManHan;

use App\Console\Commands\ManHan;
use App\Models\Man;
use App\Service\LogTrait;
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
        }catch (\Exception $e) {
            $this->logWrite($e->getMessage());
            $this->logWrite($e->getTraceAsString());
        }
    }
}
