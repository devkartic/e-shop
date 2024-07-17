<?php

namespace App\Http\Controllers\Admin\AccessControl;

use App\CacheRepositories\Modules;
use App\Http\Controllers\Controller;
use App\Models\Admin\AccessControl\Link;
use App\Models\Admin\AccessControl\Permission;
use App\Models\Admin\AccessControl\Role;
use App\Models\Admin\AccessControl\Route;
use App\Models\Admin\AccessControl\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PermissionController extends Controller
{

    /**
     * Check permission for routs, roles, links.
     *
     * @return Response or exception
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
     * @return \Inertia\Response
     */
    public function index(Request $request): \Inertia\Response
    {
        $role_id = $request->input('role_id')?: Auth::user()->role_id;
        return Inertia::render('Admin/AccessControl/Permissions/Index', [
            'roles' => Role::all(),
            'filters' => [
                'role' => $role_id ? Role::find($role_id) : [],
                'data' => $role_id ? $this->get_permissions($role_id) : null
            ]
        ]);
    }

    /**
     * Get the specified resource from storage.
     *
     * @param Permission $permission
     * @return Collection
     */
    public function get_permissions($role_id): Collection
    {
        $links = Link::all();
        foreach ($links as $link) {
            $link->index = Permission::has_permission($link->id, 'index', $role_id);
            $link->create = Permission::has_permission($link->id, 'create', $role_id);
            $link->edit = Permission::has_permission($link->id, 'edit', $role_id);
            $link->destroy = Permission::has_permission($link->id, 'destroy', $role_id);
        }
        return $links;
    }

    /**
     * Create or remove the specified permission for specified roles, links and routes.
     *
     * @param Permission $permission
     * @return RedirectResponse
     */
    public function update($link_id, Request $request): RedirectResponse
    {
        $role_id = $request->input('role_id');
        if ($role_id == Role::$default_admin) {
            abort(403, 'Access Forbidden!');
        } // Supper Admin checked and terminate

        $link_id = $request->input('link_id');
        $index = filter_var($request->input('index'), FILTER_VALIDATE_BOOLEAN);
        $create = filter_var($request->input('create'), FILTER_VALIDATE_BOOLEAN);
        $edit = filter_var($request->input('edit'), FILTER_VALIDATE_BOOLEAN);
        $destroy = filter_var($request->input('destroy'), FILTER_VALIDATE_BOOLEAN);

        $index_route = Route::where('name', '=', 'index')->first();
        $create_route = Route::where('name', '=', 'create')->first();
        $edit_route = Route::where('name', '=', 'edit')->first();
        $destroy_route = Route::where('name', '=', 'destroy')->first();

        $index_route->permission = $index;
        $create_route->permission = $create;
        $edit_route->permission = $edit;
        $destroy_route->permission = $destroy;

        $permissions_routes = array($index_route, $create_route, $edit_route, $destroy_route);

        foreach ($permissions_routes as $route){
            $find_permission = Permission::where(['role_id' => $role_id, 'link_id' => $link_id, 'route_id' => $route->id]);
            if ($route->permission && $find_permission) {
                Permission::create([
                    'role_id' => $role_id,
                    'link_id' => $link_id,
                    'route_id' => $route->id
                ]);
            } else {
                if ($find_permission) $find_permission->delete();
            }
        }

        Modules::cache_forget($role_id);

        return redirect()->route('permissions.index', ['role_id'=> $role_id])->with('message', "Permission updated successfully!");
    }

    /**
     * Verify the specified permission for specified roles, links and routes.
     *
     * @param Permission $permission
     * @return Response
     */
    public static function permission_verify(): bool
    {
        self::initial_verification(Auth::user());
        $link_id = null;
        $route_resource_name_array = explode('.', request()->route()->getName());
        $link_name = $route_resource_name_array[0];
        $has_link = Link::where('url', $link_name)->first();
        if ($has_link) {
            $link_id = $has_link->id;
        }
        $route_name = self::routes_verify($route_resource_name_array[1]);
        $hasPermission = Permission::has_permission($link_id, $route_name);
        if ($hasPermission) {
            return true;
        }
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
        if (User::verify_default_admin()) {
            return $user;
        }
        if (empty(Auth::user()->email_verified_at)) {
            abort(403, 'Access Unauthorized! Email not verified.');
        }
        if (empty(Auth::user()->status)) {
            abort(403, 'Access Forbidden! Profile has been disabled.');
        }
        return $user;
    }


}
