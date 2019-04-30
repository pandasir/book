<?php
/**
 * @author: 黄浩
 * @email: huanghao1054@gmail.com
 * @since: 19-4-29
 */

namespace App\Service\Man\TxMan;


class Parse
{
    private static $_instance;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if( is_null(self::$_instance) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function parseList($html)
    {
        preg_match_all('/(\/Comic\/comicInfo\/id\/[\d].*?)"/', $html, $urls);
        $urls = $urls[1];
        return $urls;
    }

    public function parseInfo($html)
    {
    }

    public function parseImage($html)
    {

    }
}