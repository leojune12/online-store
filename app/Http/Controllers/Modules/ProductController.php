<?php

namespace App\Http\Controllers\Modules;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('category:id,name')->paginate(48);

        return inertia('Product/Products', [
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shop = Auth::user()->shop;

        if ($shop) {

            $categories = Category::get(['id', 'name']);

            return inertia('Product/FormProduct', [
                'title' => 'Create',
                'categories' => $categories,
            ]);
        } else {

            return redirect(route('shop.create'))->with('alert', [
                'status' => 'info',
                'message' => 'Create a shop where you can display your products.'
            ]);;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        Validator::make($request->all(), [
            'category_id' => ['required'],
            'name' => ['required', 'string', 'min:20', 'max:255', 'unique:shops'],
            'description' => ['nullable', 'string', 'min:20', 'max:500'],
            'price' => ['required', 'min:1'],
            'stock' => ['required', 'min:0'],
            'condition' => [],
            'publish' => [],
            'cover_image' => ['required', 'image', 'max:1024'],
            'image_1' => ['nullable', 'image', 'max:1024'],
            'image_2' => ['nullable', 'image', 'max:1024'],
            'image_3' => ['nullable', 'image', 'max:1024'],
        ])->validateWithBag('submitProduct');

        DB::beginTransaction();

        try {

            $shop = Shop::create([
                'user_id' => Auth::id(),
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description
            ]);

            if ($request->photo) {
                $shop->addMediaFromRequest('photo')->toMediaCollection('shop_cover_photos');
            }

            DB::commit();

            return redirect(route('shop.index'))->with('alert', [
                'status' => 'success',
                'message' => 'Shop created successfully!'
            ]);
        } catch (Throwable $e) {

            dd($e);

            DB::rollBack();

            return back()->with('alert', [
                'status' => 'error',
                'message' => 'Whoops! Something went wrong. Please try again.',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return inertia('Product/ShowItem', [
            'product' => $product,
            'categories' => $product->category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
