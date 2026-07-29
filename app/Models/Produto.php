<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'quantidade'
    ];

    protected $casts = [
        'preco' => 'decimal:2',
        'quantidade' => 'integer',
    ];

    public function scopeFiltrar(Builder $query, array $filtros): Builder
    {
        return $query
            ->when(
                $filtros['name'] ?? null,
                fn (Builder $query, string $nome): Builder => $query->where('nome', 'like', "%{$nome}%")
            )
            ->when(
                $filtros['min_price'] ?? null,
                fn (Builder $query, float|string $precoMinimo): Builder => $query->where('preco', '>=', $precoMinimo)
            )
            ->when(
                $filtros['max_price'] ?? null,
                fn (Builder $query, float|string $precoMaximo): Builder => $query->where('preco', '<=', $precoMaximo)
            )
            ->when(
                $filtros['min_stock'] ?? null,
                fn (Builder $query, int|string $estoqueMinimo): Builder => $query->where('quantidade', '>=', $estoqueMinimo)
            )
            ->when(
                $filtros['max_stock'] ?? null,
                fn (Builder $query, int|string $estoqueMaximo): Builder => $query->where('quantidade', '<=', $estoqueMaximo)
            );
    }
}
