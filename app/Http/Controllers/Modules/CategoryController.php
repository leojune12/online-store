<?php

namespace App\Http\Controllers\Modules;

use Throwable;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $alert = $request->session()->get('alert');

        $categories = Category::orderBy('id', 'DESC')->paginate(10);

        return inertia('Category/Categories', [
            'categories' => $categories,
            'alert' => $alert
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('Category/FormCategory', [
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
            'name' => ['required', 'string', 'max:255', 'unique:categories'],
        ])->validateWithBag('submitCategory');

        try {

            Category::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
            ]);

            return redirect('categories')->with('alert', [
                'status' => 'success',
                'message' => 'Category created successfully!'
            ]);
        } catch (Throwable $e) {

            return back()->with('alert', [
                'status' => 'error',
                'message' => 'Whoops! Something went wrong. Please try again.',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return inertia('Category/FormCategory', [
            'title' => 'Update',
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', Rule::unique('categories')->ignore($category->id)],
        ])->validateWithBag('submitCategory');

        try {

            $category->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
            ]);

            return redirect('categories')->with('alert', [
                'status' => 'success',
                'message' => 'Category updated successfully!'
            ]);
        } catch (Throwable $e) {

            return back()->with('alert', [
                'status' => 'error',
                'message' => 'Whoops! Something went wrong. Please try again.',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        try {

            $category->delete();

            return redirect('categories')->with('alert', [
                'status' => 'success',
                'message' => 'Category deleted successfully!'
            ]);
        } catch (Throwable $e) {

            return back()->with('alert', [
                'status' => 'error',
                'message' => 'Whoops! Something went wrong. Please try again.',
            ]);
        }
    }
}
