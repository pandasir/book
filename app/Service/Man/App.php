<?php
/**
 * @author: 黄浩
 * @email: huanghao1054@gmail.com
 * @since: 19-4-29
 */

namespace App\Service\Man;

use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Psr7\Response;

class App extends AppAbstract implements AppInterface
{
    public function __construct()
    {
        parent::__construct();
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
        $promise->wait();
        return $data;
    }

    public function image($list)
    {
        /**
         * @var $promise Promise
         */
        $promise = null;
        $data = [];
        foreach ( $list as $key => $url ) {
            $promise = $this->http->getAsync($url)->then(function (Response $response) use (&$data, $key) {
                $data[$key] = $this->parse->parseImage($response->getBody()->getContents());
            });
        }
        $promise->wait();
        return $data;
    }
}

