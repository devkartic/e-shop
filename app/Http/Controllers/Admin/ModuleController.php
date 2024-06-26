<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Menu;
use App\Models\Admin\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * Check permission for routs, roles, links.
     *
     * @return \Illuminate\Http\Response or exception
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modules = Module::all();

        return view('admin.layouts.modules.index', compact('modules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menus = Menu::all();
        return view('admin.layouts.modules.create', compact('menus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->create_validator($request);

        Module::create([
            'name' => $request->input('name'),
            'fa_icon' => $request->input('fa_icon'),
            'menu_id' => $request->input('menu_id'),
            'order_number' => $request->input('order_number'),
            'status' => filter_var($request->input('is_checked'), FILTER_VALIDATE_BOOLEAN)
        ]);

        return response()->json(['success' =>'Module created successfully']);
    }

    private function create_validator($request){
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:modules,name'],
            'menu_id' => ['required'],
            'order_number' => ['integer', 'nullable', 'max:100']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function show(Module $module)
    {
        return view('admin.layouts.modules.show', compact('module'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function edit(Module $module)
    {
        $menus = Menu::all();
        return view('admin.layouts.modules.edit', compact('menus', 'module'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Module $module)
    {
        $this->update_validator($request, $module);

        $module->name = $request->input('name');
        $module->fa_icon = $request->input('fa_icon');
        $module->menu_id = $request->input('menu_id');
        $module->order_number = $request->input('order_number');
        $module->status = filter_var($request->input('is_checked'), FILTER_VALIDATE_BOOLEAN);
        $module->save();

        return response()->json(['success' =>'Module updated successfully']);
    }

    private function update_validator($request, $module){
        $request->validate([
            'name' => ['required', 'string', 'max:255', "unique:modules,name,$module->id"],
            'menu_id' => ['required'],
            'order_number' => ['integer', 'nullable', 'max:100']
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function destroy(Module $module)
    {
        $module->delete();
        return response()->json(['success' =>'Module deleted successfully']);
    }
}
