<?php

namespace App\Http\Controllers\Modules;

use Throwable;
use App\Models\Shop;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shop = Auth::user()->shop;

        if ($shop) {

            return redirect(route('shop.edit', $shop->id));
        } else {

            return redirect(route('shop.create'));
        }
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
            return redirect(route('shop.edit', $shop->id));
        }

        return inertia('Shop/FormShop', [
            'title' => 'Create',
        ]);
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
            'name' => ['required', 'string', 'max:255', 'unique:shops'],
            'description' => ['nullable', 'string', 'max:500'],
            'photo' => ['image', 'max:1024']
        ])->validateWithBag('submitShop');

        DB::beginTransaction();

        try {

            $shop = Shop::create([
                'user_id' => Auth::id(),
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description
            ]);

            if ($request->photo) {
                $shop->addMediaFromRequest('photo')->toMediaCollection('cover_photos');
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
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function show(Shop $shop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function edit(Shop $shop)
    {
        if (Auth::user()->shop->id != $shop->id) {
            abort(403);
        }

        $cover_photo = $shop->getFirstMediaUrl('cover_photos');

        return inertia('Shop/FormShop', [
            'title' => 'Update',
            'shop' => $shop,
            'cover_photo' => $cover_photo,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shop $shop)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop)
    {
        //
    }

    public function updateShop(Request $request, Shop $shop)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', Rule::unique('shops')->ignore($shop->id)],
            'description' => ['nullable', 'string', 'max:500'],
            'photo' => ['image', 'max:1024']
        ])->validateWithBag('submitShop');

        // dd($request->all());

        DB::beginTransaction();

        try {

            $shop->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description
            ]);

            if ($request->photo) {
                $shop->addMediaFromRequest('photo')->toMediaCollection('cover_photos');
            }

            DB::commit();

            return redirect(route('shop.index'))->with('alert', [
                'status' => 'success',
                'message' => 'Shop updated successfully!'
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

    public function deleteCoverPhoto(Shop $shop)
    {
        $cover_photo = $shop->getFirstMedia('cover_photos');

        try {

            $cover_photo->delete();

            return redirect(route('shop.index'))->with('alert', [
                'status' => 'success',
                'message' => 'Cover photo deleted successfully!'
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
