<?php

namespace App\Services;

use Carbon\Carbon;
use Spatie\OpeningHours\Exceptions\MaximumLimitExceeded;
use Spatie\OpeningHours\Exceptions\SearchLimitReached;
use Spatie\OpeningHours\OpeningHours;
use DateTime;

class RestaurantService
{
    /**
     * @throws SearchLimitReached
     * @throws MaximumLimitExceeded
     */
    public static function getOpeningInfo($restaurant): string
    {
        if ($restaurant->opening_hours == []) {
            return "It's closed.";
        }

//        dd($restaurant->opening_hours);

        $openingHours = OpeningHours::create($restaurant->opening_hours);
        $now = new DateTime('now');
        $range = $openingHours->currentOpenRange($now);

        if ($range) {
            return "Open now. It will close at " . $range->end() . "\n";
        }

//        dd($openingHours->nextOpen($now));

        $openingDayTranslate = (new Carbon($openingHours->nextOpen($now)))->isoFormat('dddd HH:mm');

        return "It's closed. It will re-open at " . $openingDayTranslate . "\n";
    }

    public static function getOpeningHoursTableForJavascript($restaurant): array
    {
        $openingHours = [
            'monday' => [
                'from' => '09:00',
                'to' => '17:30',
                'is_active' => false
            ],
            'tuesday' => [
                'from' => '09:00',
                'to' => '17:30',
                'is_active' => false
            ],
            'wednesday' => [
                'from' => '09:00',
                'to' => '17:30',
                'is_active' => false
            ],
            'thursday' => [
                'from' => '09:00',
                'to' => '17:30',
                'is_active' => false
            ],
            'friday' => [
                'from' => '09:00',
                'to' => '17:30',
                'is_active' => false
            ],
            'saturday' => [
                'from' => '09:00',
                'to' => '17:30',
                'is_active' => false
            ],
            'sunday' => [
                'from' => '09:00',
                'to' => '17:30',
                'is_active' => false
            ],
        ];

        if ($restaurant->opening_hours == []) {
            return $openingHours;
        }

        foreach ($restaurant->opening_hours as $key => $value) {
            $timesArray = explode('-', $value[0]);

            $openingHours[$key] = [
                'from' => $timesArray[0],
                'to' => $timesArray[1],
                'is_active' => true
            ];
        }

        return $openingHours;
    }
}
