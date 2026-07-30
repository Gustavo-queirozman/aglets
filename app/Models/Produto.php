<?php

namespace App\Models;

use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Produto extends Model
{
    use HasFactory;

    private const CACHE_STORE = 'redis';

    private const CACHE_TTL_IN_SECONDS = 600;

    private const LISTAGEM_CACHE_PREFIX = 'produtos:listagem:';

    private const LISTAGEM_CACHE_KEYS = 'produtos:listagem:chaves';

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

    protected static function booted(): void
    {
        static::saved(static function (): void {
            self::invalidarCacheDaListagem();
        });

        static::deleted(static function (): void {
            self::invalidarCacheDaListagem();
        });
    }

    public static function listarComCache(array $filtros): Collection
    {
        $chaveDeCache = self::gerarChaveDeCacheParaListagem($filtros);

        self::registrarChaveDeCacheDaListagem($chaveDeCache);

        return self::cacheDaListagem()->remember(
            $chaveDeCache,
            now()->addSeconds(self::CACHE_TTL_IN_SECONDS),
            fn (): Collection => self::query()
                ->filtrar($filtros)
                ->get()
        );
    }

    public static function gerarChaveDeCacheParaListagem(array $filtros): string
    {
        ksort($filtros);

        return self::LISTAGEM_CACHE_PREFIX.md5(json_encode($filtros, JSON_THROW_ON_ERROR));
    }

    public static function invalidarCacheDaListagem(): void
    {
        $cache = self::cacheDaListagem();
        $chaves = $cache->get(self::LISTAGEM_CACHE_KEYS, []);

        foreach ($chaves as $chave) {
            if (is_string($chave)) {
                $cache->forget($chave);
            }
        }

        $cache->forget(self::LISTAGEM_CACHE_KEYS);
    }

    public static function cacheDaListagem(): CacheRepository
    {
        return Cache::store(self::CACHE_STORE);
    }

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

    private static function registrarChaveDeCacheDaListagem(string $chaveDeCache): void
    {
        $cache = self::cacheDaListagem();
        $chaves = $cache->get(self::LISTAGEM_CACHE_KEYS, []);

        if (! in_array($chaveDeCache, $chaves, true)) {
            $chaves[] = $chaveDeCache;

            $cache->forever(self::LISTAGEM_CACHE_KEYS, $chaves);
        }
    }
}
