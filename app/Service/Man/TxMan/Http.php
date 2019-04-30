<?php
/**
 * @author: 黄浩
 * @email: huanghao1054@gmail.com
 * @since: 19-4-29
 */

namespace App\Service\Man\TxMan;


use GuzzleHttp\Client;

class Http
{
    private static $_instance;

    private static $option = [
        'base_uri'     => 'https://ac.qq.com',
        'verify'       => false,
    ];

    private function __construct() {}

    public static function getInstance(array $option = [])
    {
        if( is_null(self::$_instance) ) {
            self::$_instance = new Client(array_merge(self::$option, $option));
        }
        return self::$_instance;
    }
}