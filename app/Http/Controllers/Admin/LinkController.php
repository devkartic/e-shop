<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Link;
use App\Models\Admin\Module;
use Illuminate\Http\Request;

class LinkController extends Controller
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
        $links = Link::all();
        return view('admin.layouts.links.index', compact('links'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modules = Module::all();
        return view('admin.layouts.links.create', compact('modules'));
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

        Link::create([
            'name' => $request->input('name'),
            'url' => $request->input('link_url'),
            'fa_icon' => $request->input('fa_icon'),
            'module_id' => $request->input('module_id'),
            'order_number' => $request->input('order_number'),
            'status' => filter_var($request->input('is_checked'), FILTER_VALIDATE_BOOLEAN)
        ]);

        return response()->json(['success' =>'Module created successfully']);
    }

    private function create_validator($request){
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:links,name'],
            'link_url' => ['required', 'string'],
            'module_id' => ['required'],
            'order_number' => ['integer', 'nullable', 'max:100']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function show(Link $link)
    {
        return view('admin.layouts.links.show', compact('link'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function edit(Link $link)
    {
        $modules = Module::all();
        return view('admin.layouts.links.edit', compact('modules', 'link'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Link $link)
    {
        $this->update_validator($request, $link);

        $link->name = $request->input('name');
        $link->url = $request->input('link_url');
        $link->fa_icon = $request->input('fa_icon');
        $link->module_id = $request->input('module_id');
        $link->order_number = $request->input('order_number');
        $link->status = filter_var($request->input('is_checked'), FILTER_VALIDATE_BOOLEAN);
        $link->save();

        return response()->json(['success' =>'Link updated successfully']);
    }

    private function update_validator($request, $link){
        $request->validate([
            'name' => ['required', 'string', 'max:255', "unique:links,name, $link->id"],
            'link_url' => ['required', 'string'],
            'module_id' => ['required'],
            'order_number' => ['integer', 'nullable', 'max:100']
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function destroy(Link $link)
    {
        $link->delete();
        return response()->json(['success' =>'Link deleted successfully']);
    }
}
