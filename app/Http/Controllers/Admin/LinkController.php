<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Link;
use App\Models\Admin\Module;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LinkController extends Controller
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
        return Inertia::render('Admin/Links/Index', [
            'modules' => Module::all(),
            'links' => Link::query()
                ->when($request->input('search'), function ($query, $search) {
                    $query->where('name', 'like', "%$search%")->orWhere('url', 'like', "%$search%");
                })
                ->orderBy('id', 'desc')
                ->paginate(10)
                ->withQueryString()
                ->through(fn($link) => [
                    'module_id' => $link->module_id,
                    'id' => $link->id,
                    'module' => $link->molude,
                    'name' => $link->name,
                    'url' => $link->url,
                    'fa_icon' => $link->fa_icon,
                    'status' => $link->status,
                    'order_number' => $link->order_number
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
            'module_id' => ['required', 'integer'],
            'name' => 'required|string|max:255|unique:' . Link::class,
            'url' => ['required', 'string'],
            'fa_icon' => ['nullable'],
            'order_number' => ['integer', 'nullable', 'max:100']
        ]);

        Link::create([
            'module_id' => $request->module_id,
            'name' => $request->name,
            'url' => $request->url,
            'fa_icon' => $request->fa_icon,
            'status' => $request->is_active ? 1 : 0,
            'order_number' => $request->order_number,
        ]);

        return redirect()->route('links.index')->with('message', 'Created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param Link $link
     * @return Response
     */
    public function show(Link $link)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Link $link
     * @return Response
     */
    public function edit(Link $link)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Link $link
     * @return RedirectResponse
     */
    public function update(Request $request, Link $link): RedirectResponse
    {
        $request->validate([
            'module_id' => ['required','integer'],
            'name' => 'required|string|max:255|unique:' . Link::class . ',id',
            'url' => ['required', 'string'],
            'fa_icon' => ['nullable'],
            'order_number' => ['integer', 'nullable', 'max:100']
        ]);

        $link->module_id = $request->input('module_id');
        $link->name = $request->input('name');
        $link->url = $request->input('url');
        $link->fa_icon = $request->input('fa_icon');
        $link->order_number = $request->input('order_number');
        $link->status = filter_var($request->input('is_active'), FILTER_VALIDATE_BOOLEAN);
        $link->save();

        return redirect()->route('links.index')->with('message', 'Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Link $link
     * @return RedirectResponse
     */
    public function destroy(Link $link)
    {
        $link->delete();
        return redirect()->route('links.index')->with('message', 'Deleted successfully!');
    }
}
