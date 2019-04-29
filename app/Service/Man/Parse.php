<?php
/**
 * @author: 黄浩
 * @email: huanghao1054@gmail.com
 * @since: 19-4-29
 */

namespace App\Service\Man;


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
        preg_match_all('/<a href="(\/book\/.*)">/', $html, $match);
        $match = $match[1] ?? [];
        return $match;
    }

    public function parseInfo($html)
    {
        preg_match('/<img data-original="(.*?)" .*>/', $html, $image);
        $image = $image[1];

        preg_match('/<a href="javascript:;">(.*)<\/a>/', $html, $name);
        $name = $name[1];

        preg_match('/<i>作者：(.*)<\/i>/', $html, $author);
        $author = $author[1];

        preg_match('/<i>简介：<\/i>(.*)<\/div>/', $html, $desc);
        $desc = $desc[1] ?? '';

        preg_match('/<span>状态：<i>(.*)<\/i><\/span>/', $html, $status);
        $status = $status[1] ?? '';

        preg_match('/<span>人气：<i>(.*)<\/i><\/span>/', $html, $pop);
        $pop = $pop[1];

        preg_match('/<a href="\/booklist\/.*"><span>(.*)<\/span><\/a>/', $html, $class);
        $class = $class[1];

        preg_match_all('/<li idx="0"><a href="(.*)"><b>.*<\/b><\/a><\/li>/', $html, $list);
        $list = $list[1] ?? [];

        return compact('image', 'name', 'author', 'desc', 'status', 'pop', 'class', 'list');
    }

    public function parseImage($html)
    {
        preg_match_all('/<img class="lazy" data-original="(.*)"/', $html, $image);
        $image = $image[1] ?? [];

        preg_match('/<span>(第.*话)<\/span>/', $html, $title);
        $title = $title[1] ?? '';

        return compact('title', 'image');
    }
}