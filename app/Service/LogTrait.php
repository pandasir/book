<?php

namespace App\Service;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

trait LogTrait
{
    public function logWrite($content, $logName = false, $daily = true)
    {
        $showComment = env('COMMENT_WHEN_LOGGING', false);
        if ($showComment) {
            if (method_exists($this, 'comment')) {
                $errorWordList = [
                    'error',
                    'exception',
                    'failed',
                    'notice',
                ];
                preg_match_all('#(' . implode('|', $errorWordList) . ')#i', $content, $matches);
                if (isset($matches[0]) && !empty($matches[0])) {
                    $this->error($content);
                } else {
                    $this->info($content);
                }
            }
        }
        if ($logName == false) {
            if (!is_null($this->logName)) {
                $logName = $this->logName;
            } else {
                throw new \Exception('you need define logName before using it');
            }
        }

        if (empty($log)) {
            static $log = null;
        }

        $log = new Logger('');
        if ($daily) {
            $file = storage_path() . '/logs/' . date("Ymd") . '/' . $logName . '.log';
        } else {
            $file = storage_path() . '/logs/' . $logName . '.log';
        }

        $log->pushHandler(new StreamHandler($file), Logger::INFO);
        $log->addInfo($content);

        return true;
    }

    public function logPrintWrite($content, $logName = false, $accountId)
    {
        if ($logName == false) {
            if (!is_null($this->logName)) {
                $logName = $this->logName;
            } else {
                throw new \Exception('you need define logName before using it');
            }
        }

        $file = storage_path() . '/logs/' . date("Ymd") . '/' . $logName . '_print.log';

        file_put_contents($file, '================================================now account_id  ' . $accountId . "\n", FILE_APPEND);

        file_put_contents($file, print_r($content, true), FILE_APPEND);

        return;
    }


    public function logToDb($location, $message, $trace_as_string, $data = '')
    {
        $traceId = date('YmdHis') . uniqid();
        if (method_exists($this, 'arguments')) {
            $trigger = $this->arguments()['command'];
            $this->logWrite('error trace_id: ' . $traceId);
        } else {
            $trigger = get_class($this);
        }
    }

    public function measureTime()
    {
        static $startTime;
        if (is_null($startTime)) {
            $startTime = microtime(true);
        } else {
            $endTime = microtime(true);
            $timeCost = number_format($endTime - $startTime, 2, '.', '');
            $args = $this->arguments();
            $command = $args['command'];
            unset($args['command']);
            foreach ($args as $k => $v) {
                if ($v == 'foo') {
                    unset($args[$k]);
                }
            }

            $this->logWrite('timecost,' . $timeCost . ',' . $command . ',' . json_encode($args));
        }

    }


}