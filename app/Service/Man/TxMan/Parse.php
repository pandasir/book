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
        preg_match('/<img src="(.*)" alt="(.*)" height="280" width="210"\/>/', $html, $match);
        $image = $match[1];
        $name  = $match[2];

        preg_match('/<span class="first" style="padding-right: 10px;">作者：<em style="max-width: 168px;">(.*)&nbsp;.*<\/em><\/span>/', $html, $author);
        $author = $author[1];

        preg_match('/<p class="works-intro-short ui-text-gray9">\r\n(.*)<\/p>/', $html, $desc);
        $desc = str_replace(' ', '', $desc[1] ?? '');

        preg_match('/<label class="works-intro-status">(.*)<\/label>/', $html, $status);
        $status = $status[1];

        preg_match('/<span>人气：<em>(.*)<\/em><\/span>/', $html, $pop);
        $pop = $pop[1];

        preg_match_all('/<a target="_blank" title=".*：.*" href="(.*)">/', $html, $list);
        $list = $list[1];

        return compact('image', 'name', 'author', 'status', 'desc', 'pop', 'list');
    }

    public function parseImage($html)
    {

    }
}