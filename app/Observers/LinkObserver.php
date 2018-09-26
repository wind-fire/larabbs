<?php
/**
 * Created by PhpStorm.
 * User: fire
 * Date: 2018/9/26
 * Time: 9:03
 */

namespace App\Observers;

use App\Models\Link;
use Cache;

class LinkObserver
{
    // 在保存时清空 cache_key 对应的缓存
    public function saved(Link $link)
    {
        Cache::forget($link->cache_key);
    }
}