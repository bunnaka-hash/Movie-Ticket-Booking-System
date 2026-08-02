<?php

namespace App\Support;

use App\Models\Hall;
use App\Models\Seat;

/**
 * Builds a hall's seat map from its declared capacity.
 *
 * Shared by SeatSeeder and the admin hall CRUD so the two can never drift.
 *
 * Naming convention (must match the front end): `row_name` holds the row
 * letter ("A") and `seat_number` holds the number only ("7"), so the seat
 * label rendered as row_name . seat_number reads "A7".
 */
class SeatLayout
{
    /**
     * Split a capacity into rows, returning the seat count per row.
     * Prefers a row width between 8 and 14 that divides the total evenly;
     * otherwise falls back to 12 per row with a shorter last row.
     */
    public static function rowsFor(int $totalSeats): array
    {
        $perRow = 12;

        for ($width = 14; $width >= 8; $width--) {
            if ($totalSeats % $width === 0) {
                $perRow = $width;
                break;
            }
        }

        $rows = [];
        $remaining = $totalSeats;

        while ($remaining > 0) {
            $rows[] = min($perRow, $remaining);
            $remaining -= $perRow;
        }

        return $rows;
    }

    /**
     * Insert a full seat map for the hall. Assumes the hall has no seats yet.
     */
    public static function generate(Hall $hall): void
    {
        $isVipHall = str_contains(strtolower($hall->name), 'vip');
        $seats = [];
        $rowIndex = 0;

        foreach (self::rowsFor($hall->total_seats) as $seatsInRow) {
            $rowName = chr(65 + $rowIndex); // A, B, C, ...

            for ($number = 1; $number <= $seatsInRow; $number++) {
                $seats[] = [
                    'hall_id' => $hall->id,
                    'row_name' => $rowName,
                    'seat_number' => (string) $number,
                    'seat_type' => self::seatType($rowName, $isVipHall),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            $rowIndex++;
        }

        foreach (array_chunk($seats, 200) as $chunk) {
            Seat::insert($chunk);
        }
    }

    /**
     * VIP halls are entirely VIP seating; standard halls get two VIP rows
     * (C and D) in the middle of the room, matching the seat-selection UI.
     */
    private static function seatType(string $rowName, bool $isVipHall): string
    {
        if ($isVipHall) {
            return 'vip';
        }

        return in_array($rowName, ['C', 'D'], true) ? 'vip' : 'regular';
    }
}
