<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\RestaurantRessource;
use App\Models\Restaurant;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RestaurantController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return RestaurantRessource::collection(Restaurant::with('products.images')->paginate(10));
    }

    public function show($id): RestaurantRessource
    {
        return new RestaurantRessource(Restaurant::with('products.images')->findOrFail($id));
    }
}
