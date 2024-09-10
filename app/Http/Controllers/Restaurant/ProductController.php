<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Restaurant\StoreUpdateProductRequest;
use App\Models\Product;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function index(Request $request): Response
    {
//        $products = Product::with(['images'])->paginate(10);
        $products = Product::with(['images'])->where('restaurant_id', $request->user()->restaurant->id)->get();

        return Inertia::render('Restaurant/Product/Edit', [
            'status' => session('status'),
            'products' => $products,
        ]);
    }

    public function show(Request $request, $language, Product $product)
    {
        if ($request->user()->cannot('view', $product)) {
            abort(404);
        }

        return $product->load('images');
    }

    public function store(StoreUpdateProductRequest $request)
    {
        $product = Product::query()->create([
            'restaurant_id' => $request->user()->restaurant->id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        if ($request->images != []) {
            ImageService::store(
                temporary_images: $request->images,
                disk: 'products_image',
                foreign_key: 'product_id',
                foreign_key_value: $product->id
            );
        }

        return Redirect::route('restaurant.products', $request->language)->with('success', 'Success');
    }

    public function update(StoreUpdateProductRequest $request, $language, Product $product)
    {
        if ($request->user()->cannot('update', $product)) {
            abort(404);
        }

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->save();

        if ($request->images != []) {
            ImageService::store(
                temporary_images: $request->images,
                disk: 'products_image',
                foreign_key: 'product_id',
                foreign_key_value: $product->id
            );
        }

        return Redirect::route('restaurant.products', $language)->with('success', 'Success');
    }

    public function delete(Request $request, $language, Product $product)
    {
        if ($request->user()->cannot('delete', $product)) {
            abort(404);
        }

        Storage::disk('products_image')->deleteDirectory($product->id);

        Product::destroy($product->id);

        return Redirect::route('restaurant.products', $language)->with('success', 'Success');
    }
}
