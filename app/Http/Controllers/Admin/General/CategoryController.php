<?php

namespace App\Http\Controllers\Admin\General;

use App\Http\Controllers\Admin\AccessControl\PermissionController;
use App\Http\Controllers\Controller;
use App\Models\Admin\AccessControl\User;
use App\Models\Admin\General\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CategoryController extends Controller
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
    public function index(Request $request): \Inertia\Response
    {
        return Inertia::render('Admin/General/Categories/Index', [
            'categories' => Category::query()
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
            'name' => 'required|string|max:255|unique:' . Category::class,
            'order_number' => 'integer|nullable',
        ]);

        Category::create([
            'name' => $request->name,
            'status' => $request->status ? 1 : 0,
            'order_number' => $request->order_number,
        ]);

        return redirect()->route('categories.index')->with('message', 'Created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:' . Category::class . ',id',
            'order_number' => 'integer|nullable',
        ]);

        $category->name = $request->name;
        $category->status = $request->status ? 1 : 0;
        $category->order_number = $request->order_number;
        $category->save();

        return redirect()->route('categories.index')->with('message', 'Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('message', 'Deleted successfully!');
    }
}