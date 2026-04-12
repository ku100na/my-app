<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TravelPlanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',

            'country' => 'required|string|max:100',
            'city' => 'required|string|max:100',

            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',

            'overview' => 'nullable|string|max:2000',
            'photo_url' => 'nullable', 'image', 'max:2048',

            'days' => 'array',
            'days.*.title' => 'nullable|string|max:255',

            'days.*.spots' => 'array',
            'days.*.spots.*.name' => 'nullable|string|max:255',
            'days.*.spots.*.hours' => 'nullable',
            'days.*.spots.*.minutes' => 'nullable|integer|min:0|max:59',
            'days.*.spots.*.review' => 'nullable|string',
            'days.*.spots.*.name' => 'required_with:days.*.spots.*.hours,days.*.spots.*.minutes,days.*.spots.*.review',

            'review' => 'nullable|string|max:2000',
            'cost' => 'nullable|integer'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            foreach ($this->input('days', []) as $i => $day) {

                $hasSpot = collect($day['spots'] ?? [])
                    ->contains(fn($s) => !empty($s['name']));

                if ($hasSpot && empty($day['title'])) {
                    $validator->errors()->add(
                        "days.$i.title",
                        "スポットがある場合はタイトル必須です"
                    );
                }
            }
        });
    }
}
