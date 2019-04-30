<?php
/**
 * @author: 黄浩
 * @email: huanghao1054@gmail.com
 * @since: 19-4-30
 */

namespace App\Service\Man\TxMan;


use App\Service\Man\AppAbstract;
use App\Service\Man\AppInterface;

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
        // TODO: Implement info() method.
    }

    public function image($list)
    {
        // TODO: Implement image() method.
    }
}