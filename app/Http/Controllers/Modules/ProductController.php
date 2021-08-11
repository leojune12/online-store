<?php

namespace App\Http\Controllers\Modules;

use Throwable;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('category:id,name')->orderBy('created_at', 'DESC')->paginate(48);

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
            ]);
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

        Validator::make($request->all(), [
            'category' => ['required'],
            'name' => ['required', 'string', 'min:20', 'max:255', 'unique:products'],
            'description' => ['required', 'string', 'min:20', 'max:500'],
            'price' => ['required', 'numeric', 'min:1'],
            'stock' => ['required', 'numeric', 'min:0'],
            'condition' => [],
            'publish' => [],
            'cover_image' => ['required', 'image', 'max:1024'],
            'image_1' => ['nullable', 'image', 'max:1024'],
            'image_2' => ['nullable', 'image', 'max:1024'],
            'image_3' => ['nullable', 'image', 'max:1024'],
        ])->validateWithBag('submitProduct');

        DB::beginTransaction();

        try {

            $shop = Auth::user()->shop;

            $product = Product::create([
                'shop_id' => $shop->id,
                'category_id' => $request->category,
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'price' => $request->price,
                'stock' => $request->stock,
                'condition' => $request->condition,
                'publish' => 1,
            ]);

            if ($request->cover_image) {
                $product->addMediaFromRequest('cover_image')->toMediaCollection('product_cover_image');

                if ($request->image_1) {
                    $product->addMediaFromRequest('image_1')->toMediaCollection('product_images');
                }

                if ($request->image_2) {
                    $product->addMediaFromRequest('image_2')->toMediaCollection('product_images');
                }

                if ($request->image_3) {
                    $product->addMediaFromRequest('image_3')->toMediaCollection('product_images');
                }
            }

            DB::commit();

            return redirect(route('products.index'))->with('alert', [
                'status' => 'success',
                'message' => 'Product created successfully!'
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
        $shop = Auth::user()->shop;

        if ($shop) {

            $cover_image_media = $product->getFirstMedia('product_cover_image');

            $cover_image['id'] = $cover_image_media->id;
            $cover_image['url'] = $cover_image_media->getUrl();

            // dd($cover_image);

            $mediaItems = $product->getMedia('product_images');
            $images = [];

            foreach ($mediaItems as $item) {

                array_push($images, [
                    'id' => $item->id,
                    'url' => $item->getUrl()
                ]);
            };

            $categories = Category::get(['id', 'name']);

            return inertia('Product/FormProduct', [
                'title' => 'Create',
                'categories' => $categories,
                'product' => $product,
                'cover_image' => $cover_image,
                'images' => $images
            ]);
        } else {

            return redirect(route('shop.create'))->with('alert', [
                'status' => 'info',
                'message' => 'Create a shop where you can display your products.'
            ]);
        }
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
