<?php

namespace App\Http\Requests\Concerns;

use App\Models\Movie;
use App\Models\Showtime;
use Carbon\Carbon;
use Illuminate\Validation\Validator;

/**
 * Shared showtime scheduling rules for the store/update form requests.
 *
 * Two halls can run different films at once, but one hall cannot - so every
 * new or edited showtime is checked against the rest of its hall's schedule.
 */
trait ValidatesShowtimeSlot
{
    /**
     * Derive `end_time` from the movie's duration when the caller did not
     * supply one. The admin form relies on this; API clients that already
     * send `end_time` are unaffected.
     */
    protected function prepareForValidation(): void
    {
        if ($this->filled('end_time') || ! $this->filled(['movie_id', 'start_time'])) {
            return;
        }

        $movie = Movie::find($this->input('movie_id'));

        if (! $movie) {
            return;
        }

        try {
            $start = Carbon::parse($this->input('start_time'));
        } catch (\Exception) {
            return; // let the `date` rule report it
        }

        $this->merge([
            'end_time' => $start->copy()->addMinutes($movie->duration)->format('Y-m-d H:i:s'),
        ]);
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->errors()->isNotEmpty()) {
                return; // fields are already invalid; nothing to compare
            }

            $conflict = $this->conflictingShowtime();

            if ($conflict) {
                $validator->errors()->add('start_time', sprintf(
                    'This hall is already showing "%s" from %s to %s.',
                    $conflict->movie->title ?? 'another film',
                    Carbon::parse($conflict->start_time)->format('M d, H:i'),
                    Carbon::parse($conflict->end_time)->format('H:i'),
                ));
            }
        });
    }

    private function conflictingShowtime(): ?Showtime
    {
        $current = $this->route('showtime');

        return Showtime::with('movie')
            ->where('hall_id', $this->input('hall_id'))
            ->when($current, fn ($query) => $query->whereKeyNot($current->id ?? $current))
            // Overlap: an existing show starts before ours ends and ends after ours starts.
            ->where('start_time', '<', $this->input('end_time'))
            ->where('end_time', '>', $this->input('start_time'))
            ->first();
    }
}
