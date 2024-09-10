<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Services\RestaurantService;
use App\Services\VerificationCodeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\OpeningHours\Exceptions\MaximumLimitExceeded;
use Spatie\OpeningHours\Exceptions\SearchLimitReached;

class InfoController extends Controller
{
    /**
     * @throws SearchLimitReached
     * @throws MaximumLimitExceeded
     */
    public function edit(): Response
    {
        $restaurant = Restaurant::query()
            ->where('user_id', Auth::id())
            ->first();

        return Inertia::render('Restaurant/Info/Edit', [
            'status' => session('status'),
            'openingInfo' => RestaurantService::getOpeningInfo($restaurant),
            'openingHours' => RestaurantService::getOpeningHoursTableForJavascript($restaurant),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'phone' => 'required|string|max:255|phone:DE',
            'address' => 'required|string|max:255',
            'shipping' => 'required|string|max:2',
        ]);

        $restaurant = Restaurant::query()
            ->where('user_id', $request->user()->id)
            ->first();

        $restaurant->phone = phone($request->phone, ['DE'])->formatE164();
        $restaurant->address = $request->address;
        $restaurant->shipping = $request->shipping;

        if ($restaurant->isDirty('phone')) {
            $restaurant->phone_verified_at = null;
            VerificationCodeService::sendSmsVerificationCode($restaurant->phone, $request->user()->id);
        }

        $restaurant->save();

        return Redirect::back()->with('success', 'Success');
    }

    public function updateOpeningHours(Request $request): RedirectResponse
    {
        $opening_hours = collect($request->opening_hours)
            ->filter(fn($val, $key) => $val['is_active'])
            ->map(fn($item, $key) => [$item['from'] . '-' . $item['to']])
            ->toArray();

        Restaurant::query()
            ->where('user_id', $request->user()->id)
            ->first()
            ->update([
                'opening_hours' => $opening_hours
            ]);

        return Redirect::back()->with('success', 'Success');
    }
}
