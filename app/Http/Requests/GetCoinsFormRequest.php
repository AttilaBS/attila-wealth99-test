<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class GetCoinsFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string,array|string>
     */
    public function rules(): array
    {
        return [
            'coins' => 'nullable|string|between:3,100',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['coins' => $this->parseQueryString()]);
    }

    protected function parseQueryString(): ?string
    {
        $fullUri = $this->getRequestUri();
        $queryString = explode('?', $fullUri)[1] ?? null;
        if ($queryString) {
            $coinsString = str_replace('coins=', '', $queryString);
            $coins = explode('&', $coinsString);

            return implode(',', $coins);
        }

        return null;
    }

    public function messages(): array
    {
        return [
            'coins.between' => 'Coins must be between 3 and 100 characters.',
            'coins.string' => 'Coins must be a string.',
        ];
    }
}
