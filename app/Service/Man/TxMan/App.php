<?php
/**
 * @author: 黄浩
 * @email: huanghao1054@gmail.com
 * @since: 19-4-30
 */

namespace App\Service\Man\TxMan;


use App\Service\Man\AppAbstract;
use App\Service\Man\AppInterface;
use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Psr7\Response;

class App extends AppAbstract implements AppInterface
{
    public function __construct()
    {
        parent::__construct();
        $this->http     = \App\Service\Man\TxMan\Http::getInstance();
        $this->parse    = \App\Service\Man\TxMan\Parse::getInstance();
    }

    public function list($url)
    {
        $html = $this->http->get($url)->getBody()->getContents();
        return $this->parse->parseList($html);
    }

    public function info($list)
    {
        /**
         * @var $promise Promise
         */
        $promise = null;
        $data = [];
        array_walk($list, function ($url, $key) use (&$promise, &$data) {
            $promise = $this->http->getAsync($url)->then(function (Response $response) use (&$data, $key, $url) {
                $data[$key] = $this->parse->parseInfo($response->getBody()->getContents());
                $data[$key]['url'] = $url;
            });
        });
        $promise && $promise->wait();
        return $data;
    }

    public function image($list)
    {
        // TODO: Implement image() method.
    }
}