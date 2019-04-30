<?php
/**
 * @author: 黄浩
 * @email: huanghao1054@gmail.com
 * @since: 19-4-29
 */

namespace App\Service\Man;


interface AppInterface
{
    public function list($url);

    public function info($list);

    public function image($list);
}