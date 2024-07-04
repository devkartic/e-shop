<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'menu_id',
        'fa_icon',
        'order_number',
        'status',
    ];

    /**
     * Get the links for the module.
     */
    public function links(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Link::class);
    }

    /**
     * Get the verified modules and links for logged in user
     */

    public static function sidebar_verified_modules(string $column = 'id', string $order_by = 'asc'): object
    {
        $collections = self::orderBy($column, $order_by)->get();
        foreach ($collections as $module) {
            $module->has_permission = false;
            $links = $module->links;
            foreach ($links as $link) {
                $link->has_permission = Permission::has_permission($link->id, 'index');
                if (($module->has_permission === false) && $link->has_permission) {
                    $module->has_permission = true;
                }
            }
        }
        return $collections;
    }
}
