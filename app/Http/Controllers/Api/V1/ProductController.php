<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ProductRessource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return ProductRessource::collection(Product::with(['restaurant', 'images'])->paginate(10));
    }

    public function show($id): ProductRessource
    {
        return new ProductRessource(Product::with(['restaurant', 'images'])->findOrFail($id));
    }
}
