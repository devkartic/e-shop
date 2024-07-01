<?php

namespace App\Http\Controllers\Admin;

use App\CacheRepositories\Menus;
use App\Http\Controllers\Controller;
use App\Models\Admin\Link;
use App\Models\Admin\Permission;
use App\Models\Admin\Role;
use App\Models\Admin\Route;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{

    /**
     * Check permission for routs, roles, links.
     *
     * @return \Illuminate\Http\Response or exception
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            self::permission_verify();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('admin.layouts.permissions.index', compact('roles'));
    }

    /**
     * Get the specified resource from storage.
     *
     * @param \App\Models\Admin\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function get_permissions(Request $request): string
    {
        $role_id = $request->input('role_id');

        $role = Role::find($role_id);

        if ($role) $role = $role->name;

        $links = Link::all();

        foreach ($links as $link) {
            $link->view = Permission::has_permission($link->id, 'index', $role_id);
            $link->create = Permission::has_permission($link->id, 'create', $role_id);
            $link->edit = Permission::has_permission($link->id, 'edit', $role_id);
            $link->destroy = Permission::has_permission($link->id, 'destroy', $role_id);
        }

        return view('admin.layouts.permissions.show', compact('role', 'links'));
    }

    /**
     * Create or remove the specified permission for specified roles, links and routes.
     *
     * @param \App\Models\Admin\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function permission_handler(Request $request): bool
    {
        $role_id = $request->input('role_id');
        if ($role_id == Role::$default_admin) die(); // Supper Admin checked and terminate
        $link_id = $request->input('link_id');
        $is_checked = filter_var($request->input('is_checked'), FILTER_VALIDATE_BOOLEAN);
        $route_id = Route::where('name', '=', $request->input('route_name'))->first()->id;
        $find_permission = Permission::where(['role_id' => $role_id, 'link_id' => $link_id, 'route_id' => $route_id]);

        if ($is_checked) {
            Permission::create([
                'role_id' => $role_id,
                'link_id' => $link_id,
                'route_id' => $route_id
            ]);
        } else {
            if ($find_permission->first()) $find_permission->delete();
        }
        Menus::cache_forget($role_id);
        return true;
    }

    /**
     * Verify the specified permission for specified roles, links and routes.
     *
     * @param \App\Models\Admin\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public static function permission_verify(): bool
    {
        self::initial_verification(Auth::user());
        $link_id = null;
        $route_resource_name_array = explode('.', request()->route()->getName());
        $link_name = $route_resource_name_array[0];
        $has_link = Link::where('url', $link_name)->first();
        if ($has_link) $link_id = $has_link->id;
        $route_name = self::routes_verify($route_resource_name_array[1]);
        $hasPermission = Permission::has_permission($link_id, $route_name);
        if ($hasPermission) return true;
        abort(403, 'Access Forbidden!');
    }

    public static function routes_verify($route_name): string
    {
        return match ($route_name) {
            'show', 'view' => 'index',
            'store', 'store_or_destroy' => 'create',
            'update', 'delete-files' => 'edit',
            default => $route_name,
        };
    }

    public static function initial_verification($user): object
    {
        if(User::verify_default_admin()) return $user;
        if (empty(Auth::user()->email_verified_at)) abort(403, 'Access Unauthorized! Email not verified.');
        if (empty(Auth::user()->status)) abort(403, 'Access Forbidden! Profile has been disabled.');
        return $user;
    }


}