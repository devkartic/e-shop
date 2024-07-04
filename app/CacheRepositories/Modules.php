<?php

namespace App\CacheRepositories;

use App\Models\Admin\Module;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Modules extends CacheHandler
{
    static string $key = 'FOR-ROLE';
    /**
     * Verify the specified modules with link permission for specified roles.
     *
     * @param column
     * @return object or null
     */
    public static function verified_modules($order_by): object | null
    {
        if(Auth::check() === false) return null;
        $cache_key = self::get_cache_key();

        if (Cache::has($cache_key)) return Cache::get($cache_key);

        return Cache::remember($cache_key, Carbon::now()->addMinute(5), function () use ($order_by) {
            return Module::sidebar_verified_modules($order_by);
        });
    }

    public static function get_cache_key($role_id = null): string
    {
        if (empty($role_id)) $role_id = Auth::user()->role_id;
        self::$key = self::$key . "-$role_id";
        return self::cache_key(self::$key);
    }

    public static function cache_forget($role_id): void
    {
        Cache::forget(self::get_cache_key($role_id));
    }


}
