<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            PermissionController::permission_verify();
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render('Admin/Roles/Index', [
            'roles' => Role::query()
                ->when($request->input('search'), function ($query, $search) {
                    $query->where('name', 'like', "%$search%");
                })
                ->orderBy('id', 'desc')
                ->paginate(10)
                ->withQueryString()
                ->through(fn($role) => [
                    'id' => $role->id,
                    'name' => $role->name,
                    'status' => $role->status,
                    'order_number' => $role->order_number
                ]),
            'filters' => $request->only(['search']),
            'can' => [
                'createUser' => Auth::user()->can('create', User::class)
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:' . Role::class,
            'order_number' => 'integer|nullable',
        ]);

        Role::create([
            'name' => $request->name,
            'status' => $request->is_active ? 1 : 0,
            'order_number' => $request->order_number,
        ]);

        return redirect()->route('roles.index')->with('message', 'Created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:' . Role::class . ',id',
            'order_number' => 'integer|nullable',
        ]);

        $role->name = $request->name;
        $role->status = $request->is_active ? 1 : 0;
        $role->order_number = $request->order_number;
        $role->save();

        return redirect()->route('roles.index')->with('message', 'Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('message', 'Deleted successfully!');
    }
}
