<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function List()
    {
        $categories = Category::paginate(10);
        return Inertia::render("Category/List", [
            'categories' => CategoryResource::collection($categories)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function Store(StoreCategoryRequest $request)
    {

        $validated = $request->validated();

        Category::create([
            'name' => $validated['name'],
            'user_id' => auth()->user()->id
        ]);

        return redirect()->back()->with('message', 'Category Added!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function Destroy(Category $category)
    {
        // dd($category);
        $category->delete();

        return redirect()->back()->with('message', 'Category deleted!');
    }
}
