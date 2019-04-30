<?php
/**
 * @author: 黄浩
 * @email: huanghao1054@gmail.com
 * @since: 19-4-29
 */

namespace App\Service\Man;

abstract class AppAbstract
{
    /**
     * Http请求器
     *
     * @var \GuzzleHttp\Client
     */
    public $http;

    /**
     * Html解析器
     *
     */
    public $parse;

    /**
     * AppAbstract constructor.
     */
    public function __construct()
    {
    }

}