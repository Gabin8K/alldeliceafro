<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\StoreUpdateCategoryRequest;
use App\Models\Category;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Category/Index', [
            'categories' => Category::with(['image'])->get(),
        ]);
    }

    public function show(Request $request, $language, Category $category): Category
    {
        return $category->load('image');
    }

    public function store(StoreUpdateCategoryRequest $request)
    {
        $data = $request->safe()->except(['images']);
        $category = Category::query()->create($data);

        if ($request->images != []) {
            ImageService::store(
                temporary_images: $request->images,
                disk: 'categories_image',
                foreign_key: 'category_id',
                foreign_key_value: $category->id
            );
        }

        return Redirect::route('admin.categories.index', $request->language)->with('success', 'Success');
    }

    public function update(StoreUpdateCategoryRequest $request, $language, Category $category)
    {
        $data = $request->safe()->except(['images']);
        $category->update($data);

        if ($request->images != []) {
            ImageService::store(
                temporary_images: $request->images,
                disk: 'categories_image',
                foreign_key: 'category_id',
                foreign_key_value: $category->id
            );
        }

        return Redirect::route('admin.categories.index', $request->language)->with('success', 'Success');
    }

    public function destroy(Request $request, $language, Category $category)
    {
        Storage::disk('categories_image')->deleteDirectory($category->id);

        Category::destroy($category->id);

        return Redirect::route('admin.categories.index', $language)->with('success', 'Success');
    }
}
