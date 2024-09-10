<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ShopController extends Controller
{
    public function index(Request $request, $language)
    {
        $data = $request->validate([
            'city' => ['required', 'string', Rule::in(array_keys(config('available_shops_cities')))],
            'by'   => ['nullable', 'string', Rule::in(['ASC', 'DESC'])],
        ]);

        $shops = Shop::with(['image'])->get();

        return Inertia::render('Shops', [
            'city' => $data['city'],
            'shops' => $shops
        ]);
    }
}
