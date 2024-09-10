<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class ArticleShopController extends Controller
{
    public function store(Request $request, $language, Shop $shop): RedirectResponse
    {
        $data = $request->validate([
            'article_id' => 'required|numeric',
            'price' => 'required|numeric',
        ]);


        if (in_array($data['article_id'], $shop->articles->pluck('id')->toArray())) {
            throw ValidationException::withMessages([
                'article_id' => 'Article already added'
            ]);
        }

        $shop->articles()->attach($data['article_id'], [
            'price' => $data['price']
        ]);

        return Redirect::back()->with('success', 'Success');
    }

    public function update(Request $request, $language, Shop $shop): RedirectResponse
    {
        $data = $request->validate([
            'article_id' => 'required|numeric',
            'price' => 'required|numeric',
        ]);


        if (!in_array($data['article_id'], $shop->articles->pluck('id')->toArray())) {
            throw ValidationException::withMessages([
                'article_id' => 'Article does not exist'
            ]);
        }

        $shop->articles()->updateExistingPivot($data['article_id'], [
            'price' => $data['price']
        ]);

        return Redirect::back()->with('success', 'Success');
    }

    public function destroy(Request $request, $language, Shop $shop): RedirectResponse
    {
        $data = $request->validate([
            'article_id' => 'required|numeric',
        ]);

        $shop->articles()->detach($data['article_id']);

        return Redirect::back()->with('success', 'Success');
    }
}
