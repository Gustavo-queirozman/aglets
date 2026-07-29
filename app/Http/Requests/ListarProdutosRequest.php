<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ListarProdutosRequest extends FormRequest
{
    private const FILTROS_PERMITIDOS = [
        'name',
        'min_price',
        'max_price',
        'min_stock',
        'max_stock',
    ];

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $name = $this->query('name', $this->query('nome'));

        $this->merge(array_filter([
            'name' => is_string($name) ? trim($name) : $name,
            'min_price' => $this->query('min_price'),
            'max_price' => $this->query('max_price'),
            'min_stock' => $this->query('min_stock'),
            'max_stock' => $this->query('max_stock'),
        ], static fn (mixed $value): bool => $value !== null && $value !== ''));
    }

    /**
     * Return the normalized filters already validated for the listing query.
     *
     * @return array<string, mixed>
     */
    public function filtros(): array
    {
        return $this->only(self::FILTROS_PERMITIDOS);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'min_price' => ['sometimes', 'numeric', 'min:0'],
            'max_price' => ['sometimes', 'numeric', 'min:0', 'gte:min_price'],
            'min_stock' => ['sometimes', 'integer', 'min:0'],
            'max_stock' => ['sometimes', 'integer', 'min:0', 'gte:min_stock'],
        ];
    }
}
