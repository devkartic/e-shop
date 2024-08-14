<?php

namespace App\Http\Controllers\Admin\General;

use App\Http\Controllers\Admin\AccessControl\PermissionController;
use App\Http\Controllers\Controller;
use App\Models\Admin\AccessControl\User;
use App\Models\Admin\General\Category;
use App\Models\Admin\General\Product;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProductController extends Controller
{
    public string $destination_path;

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
     */
    public function index(Request $request): \Inertia\Response
    {
        return Inertia::render('Admin/General/Products/Index', [
            'categories' => Category::all(),
            'products' => Product::query()
                ->when($request->input('search'), function ($query, $search) {
                    $query->where('name', 'like', "%$search%")->orWhere('description', 'like', "%$search%");
                })
                ->orderBy('id', 'desc')
                ->paginate(10)
                ->withQueryString()
                ->through(fn($collection) => [
                    'category_id' => $collection->category_id,
                    'id' => $collection->id,
                    'name' => $collection->name,
                    'description' => $collection->description,
                    'image_path' => $collection->image_path,
                    'status' => $collection->status,
                    'order_number' => $collection->order_number
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
            'category_id' => ['required', 'integer'],
            'name' => 'required|string|max:255|unique:' . Product::class,
            'description' => ['required', 'string'],
            'upload_product_image' => [
                'nullable',
                'image',
                'mimes:jpg,png',
                'max:2048'
            ],
            'order_number' => ['integer', 'nullable', 'max:100']
        ]);

        /* Product image upload */
        $product_image_path = null;
        if ($request->hasFile('upload_product_image') && $request->file('upload_product_image')->isValid()) {
            try {
                $file = $request->file('upload_product_image');
                $renamedFile = date("Y-m-d") . "-" . time() . '.' . $file->getClientOriginalExtension();
                $product_image_path = "uploads/images/products/$renamedFile";
                $file->storeAs('public', $product_image_path);
            } catch (\Exception $e) {
                dd($e->getMessage());
            }
        }

        Product::create([
            'category_id' => $request->input('category_id'),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'image_path' => $product_image_path,
            'order_number' => $request->input('order_number'),
            'status' => $request->input('status') ? 1 : 0,
        ]);

        return redirect()->route('products.index')->with('message', 'Created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {

        $request->validate([
            'category_id' => ['required', 'integer'],
            'name' => 'required|string|max:255|unique:' . Product::class . ',id',
            'description' => ['required', 'string'],
            'upload_product_image' => [
                'nullable',
                'image',
                'mimes:jpg,png',
                'max:2048'
            ],
            'order_number' => ['integer', 'nullable', 'max:100']
        ]);

        /* Product image upload */
        $product_image_path = null;
        if ($request->hasFile('upload_product_image') && $request->file('upload_product_image')->isValid()) {
            try {
                $file = $request->file('upload_product_image');
                $renamedFile = date("Y-m-d") . "-" . time() . '.' . $file->getClientOriginalExtension();
                $product_image_path = "uploads/images/products/$renamedFile";
                $file->storeAs('public', $product_image_path);
            } catch (\Exception $e) {
                dd($e->getMessage());
            }
        }

        $product->category_id = $request->input('category_id');
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        if($request->hasFile('upload_product_image')) $product->image_path = $product_image_path;
        $product->order_number = $request->input('order_number');
        $product->status = filter_var($request->input('status'), FILTER_VALIDATE_BOOLEAN);
        $product->save();

        return redirect()->route('products.index')->with('message', 'Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        File::delete(storage_path('app/public/'.$product->image_path));
        $product->delete();
        return redirect()->route('products.index')->with('message', 'Deleted successfully!');
    }
}
