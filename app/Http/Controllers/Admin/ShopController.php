<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Shop\StoreUpdateShopRequest;
use App\Models\Article;
use App\Models\Shop;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ShopController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Shop/Index', [
            'shops' => Shop::with(['image'])->get(),
        ]);
    }

    public function edit(Request $request, $language, Shop $shop): Response
    {
        $articles = Article::query()
            ->select(['id', 'name_en', 'name_de', 'name_fr'])
            ->whereNotIn('id', $shop->articles->pluck('id'))
            ->get();

        return Inertia::render('Admin/Shop/Edit', [
            'shop' => $shop->loadMissing(['image', 'articles.images']),
            'articles' => $articles,
        ]);
    }

    public function show(Request $request, $language, Shop $shop): Shop
    {
        return $shop->loadMissing('image');
    }

    public function store(StoreUpdateShopRequest $request): RedirectResponse
    {
        $data = $request->safe()->except(['images']);
        $shop = Shop::query()->create($data);

        if ($request->images != []) {
            ImageService::store(
                temporary_images: $request->images,
                disk: 'shops_image',
                foreign_key: 'shop_id',
                foreign_key_value: $shop->id
            );
        }

        return Redirect::route('admin.shops.index', $request->language)->with('success', 'Success');
    }

    public function update(StoreUpdateShopRequest $request, $language, Shop $shop)
    {
        $data = $request->safe()->except(['images']);
        $shop->update($data);

        if ($request->images != []) {
            ImageService::store(
                temporary_images: $request->images,
                disk: 'shops_image',
                foreign_key: 'shop_id',
                foreign_key_value: $shop->id
            );
        }

        return Redirect::route('admin.shops.index', $language)->with('success', 'Success');
    }

    public function destroy(Request $request, $language, Shop $shop)
    {
        Storage::disk('shops_image')->deleteDirectory($shop->id);

        $shop->delete();

        return Redirect::route('admin.shops.index', $language)->with('success', 'Success');
    }
}
