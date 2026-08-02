<?php

namespace Database\Seeders;

use App\Models\Hall;
use App\Models\Movie;
use App\Models\Showtime;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ShowtimeSeeder extends Seeder
{
    /**
     * Days of schedule to generate before and after today. The past day gives
     * the check-in and history screens something to show.
     */
    private const PAST_DAYS = 1;

    private const FUTURE_DAYS = 7;

    /**
     * Run the database seeds.
     *
     * The schedule is generated relative to today so the seeded data never
     * goes stale, and `end_time` is derived from the movie duration instead
     * of being typed by hand.
     */
    public function run(): void
    {
        $movies = Movie::where('status', 'now_showing')->orderBy('id')->get();
        $halls = Hall::orderBy('cinema_id')->orderBy('id')->get();

        if ($movies->isEmpty() || $halls->isEmpty()) {
            $this->command?->warn('No now_showing movies or halls found, skipping showtimes.');
            return;
        }

        $showtimes = [];

        for ($day = -self::PAST_DAYS; $day < self::FUTURE_DAYS; $day++) {
            $date = Carbon::today()->addDays($day);

            foreach ($halls as $hallIndex => $hall) {
                $isVipHall = str_contains(strtolower($hall->name), 'vip');
                $slots = $isVipHall ? ['13:00', '20:00'] : ['10:00', '14:00', '19:00'];

                foreach ($slots as $slotIndex => $slot) {
                    // Rotate the line-up so every hall/day shows a different film.
                    // Double modulo keeps the index positive for past days.
                    $count = $movies->count();
                    $movie = $movies[(($day + $hallIndex + $slotIndex) % $count + $count) % $count];

                    $start = $date->copy()->setTimeFromTimeString($slot);

                    $showtimes[] = [
                        'movie_id' => $movie->id,
                        'hall_id' => $hall->id,
                        'start_time' => $start->format('Y-m-d H:i:s'),
                        'end_time' => $start->copy()->addMinutes($movie->duration)->format('Y-m-d H:i:s'),
                        'price' => $this->priceFor($hall->name, $isVipHall, $start),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        foreach (array_chunk($showtimes, 200) as $chunk) {
            Showtime::insert($chunk);
        }
    }

    /**
     * VIP halls cost more, and weekends carry a $1 surcharge.
     */
    private function priceFor(string $hallName, bool $isVipHall, Carbon $start): float
    {
        $price = match (true) {
            $isVipHall => 9.00,
            str_contains($hallName, '1') => 6.00,
            default => 5.50,
        };

        if ($start->isWeekend()) {
            $price += 1.00;
        }

        return $price;
    }
}
