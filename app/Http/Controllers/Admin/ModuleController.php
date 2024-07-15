<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Menu;
use App\Models\Admin\Module;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ModuleController extends Controller
{
    /**
     * Check permission for routs, roles, links.
     *
     * @return Response or exception
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            PermissionController::permission_verify();
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
        return Inertia::render('Admin/Modules/Index', [
            'modules' => Module::query()
                ->when($request->input('search'), function ($query, $search) {
                    $query->where('name', 'like', "%$search%");
                })
                ->orderBy('id', 'desc')
                ->paginate(10)
                ->withQueryString()
                ->through(fn($module) => [
                    'id' => $module->id,
                    'name' => $module->name,
                    'status' => $module->status,
                    'order_number' => $module->order_number
                ]),
            'filters' => $request->only(['search']),
            'can' => [
                'createUser' => Auth::user()->can('create', User::class)
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:' . Module::class,
            'order_number' => 'integer|nullable',
        ]);

        Module::create([
            'name' => $request->name,
            'status' => $request->status ? 1 : 0,
            'order_number' => $request->order_number,
        ]);

        return redirect()->route('modules.index')->with('message', 'Created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param Module $module
     * @return Response
     */
    public function show(Module $module)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Module $module
     * @return Response
     */
    public function edit(Module $module)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Module $module
     * @return RedirectResponse
     */
    public function update(Request $request, Module $module)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:' . Module::class . ',id',
            'order_number' => 'integer|nullable',
        ]);

        $module->name = $request->name;
        $module->status = $request->status ? 1 : 0;
        $module->order_number = $request->order_number;
        $module->save();

        return redirect()->route('modules.index')->with('message', 'Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Module $module
     * @return RedirectResponse
     */
    public function destroy(Module $module): RedirectResponse
    {
        $module->delete();
        return redirect()->route('modules.index')->with('message', 'Deleted successfully!');
    }
}
