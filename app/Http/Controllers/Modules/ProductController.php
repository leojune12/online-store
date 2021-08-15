<?php

namespace App\Http\Controllers\Modules;

use Throwable;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
            }

            if ($request->image_1) {
                $product->addMediaFromRequest('image_1')->toMediaCollection('product_images');
            }

            if ($request->image_2) {
                $product->addMediaFromRequest('image_2')->toMediaCollection('product_images');
            }

            if ($request->image_3) {
                $product->addMediaFromRequest('image_3')->toMediaCollection('product_images');
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

            $product_cover_image = $product->getFirstMedia('product_cover_image');

            if ($product_cover_image) {
                $cover_image['id'] = $product_cover_image->id;
                $cover_image['url'] = $product_cover_image->getUrl();
            }

            $mediaItems = $product->getMedia('product_images');

            if (count($mediaItems)) {

                foreach ($mediaItems as $key => $item) {

                    ${'image_' . ($key + 1)} = [
                        'id' => $item->id,
                        'url' => $item->getUrl()
                    ];
                };
            }

            $categories = Category::get(['id', 'name']);

            return inertia('Product/FormProduct', [
                'title' => 'Update',
                'categories' => $categories,
                'product' => $product,
                'cover_image' => isset($cover_image) ? $cover_image : null,
                'image_1' => isset($image_1) ? $image_1 : null,
                'image_2' => isset($image_2) ? $image_2 : null,
                'image_3' => isset($image_3) ? $image_3 : null,
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

    public function updateProduct(Request $request, Product $product)
    {
        Validator::make($request->all(), [
            'category' => ['required'],
            'name' => ['required', 'string', 'min:20', 'max:255', Rule::unique('products')->ignore($product)],
            'description' => ['required', 'string', 'min:20', 'max:500'],
            'price' => ['required', 'numeric', 'min:1'],
            'stock' => ['required', 'numeric', 'min:0'],
            'condition' => ['nullable', 'numeric'],
            'publish' => ['nullable', 'numeric'],
            'cover_image' => ['exclude_if:cover_image_id,null', 'required', 'image', 'max:1024'],
            'image_1' => ['nullable', 'image', 'max:1024'],
            'image_2' => ['nullable', 'image', 'max:1024'],
            'image_3' => ['nullable', 'image', 'max:1024'],
            'cover_image_id' => ['nullable', 'string'],
            'image_1_id' => ['nullable', 'numeric'],
            'image_2_id' => ['nullable', 'numeric'],
            'image_3_id' => ['nullable', 'numeric'],
        ])->validateWithBag('submitProduct');

        DB::beginTransaction();

        try {

            $shop = Auth::user()->shop;

            $product->update([
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
            }

            if ($request->image_1) {
                $product->addMediaFromRequest('image_1')->toMediaCollection('product_images');
            }

            if ($request->image_2) {
                $product->addMediaFromRequest('image_2')->toMediaCollection('product_images');
            }

            if ($request->image_3) {
                $product->addMediaFromRequest('image_3')->toMediaCollection('product_images');
            }

            if ($request->cover_image_id) {
                $productMedia = $product
                    ->getMedia('product_cover_image')
                    ->where('id', $request->cover_image_id)
                    ->first();

                if ($productMedia) {
                    $productMedia->delete();
                }
            }

            $deleteMediaIds = [
                $request->image_1_id,
                $request->image_2_id,
                $request->image_3_id,
            ];

            if (count(array_filter($deleteMediaIds))) {

                foreach (array_filter($deleteMediaIds) as $id) {

                    $productMedia = $product
                        ->getMedia('product_images')
                        ->where('id', $id)
                        ->first();

                    if ($productMedia) {
                        $productMedia->delete();
                    }
                }
            }

            DB::commit();

            return redirect(route('products.index'))->with('alert', [
                'status' => 'success',
                'message' => 'Product updated successfully!'
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
}
