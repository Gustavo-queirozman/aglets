<?php

namespace Tests\Feature;

use App\Models\Produto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProdutoApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_cria_um_produto_com_sucesso(): void
    {
        $payload = [
            'nome' => 'Notebook Pro',
            'descricao' => 'Notebook para desenvolvimento',
            'preco' => 4599.90,
            'quantidade' => 8,
        ];

        $response = $this->postJson('/api/product', $payload);

        $response
            ->assertCreated()
            ->assertJsonPath('message', 'Produto criado com sucesso')
            ->assertJsonPath('produto.nome', $payload['nome'])
            ->assertJsonPath('produto.descricao', $payload['descricao'])
            ->assertJsonPath('produto.preco', '4599.90')
            ->assertJsonPath('produto.quantidade', $payload['quantidade']);

        $this->assertDatabaseHas('produtos', [
            'nome' => $payload['nome'],
            'descricao' => $payload['descricao'],
            'quantidade' => $payload['quantidade'],
        ]);
    }

    public function test_lista_os_produtos_cadastrados(): void
    {
        Produto::query()->create([
            'nome' => 'Mouse Gamer',
            'descricao' => 'Mouse com sensor optico',
            'preco' => 199.90,
            'quantidade' => 15,
        ]);

        Produto::query()->create([
            'nome' => 'Teclado Mecanico',
            'descricao' => 'Teclado ABNT2',
            'preco' => 349.90,
            'quantidade' => 6,
        ]);

        $response = $this->getJson('/api/products');

        $response
            ->assertOk()
            ->assertJsonPath('message', 'Lista de produtos')
            ->assertJsonCount(2, 'produtos')
            ->assertJsonFragment(['nome' => 'Mouse Gamer'])
            ->assertJsonFragment(['nome' => 'Teclado Mecanico']);
    }

    public function test_lista_produtos_filtrando_por_nome_e_faixa_de_preco(): void
    {
        Produto::query()->create([
            'nome' => 'Mouse Gamer RGB',
            'descricao' => 'Mouse com iluminacao RGB',
            'preco' => 199.90,
            'quantidade' => 10,
        ]);

        Produto::query()->create([
            'nome' => 'Mouse Office',
            'descricao' => 'Mouse sem fio para escritorio',
            'preco' => 89.90,
            'quantidade' => 20,
        ]);

        Produto::query()->create([
            'nome' => 'Mouse Premium',
            'descricao' => 'Mouse ergonomico premium',
            'preco' => 499.90,
            'quantidade' => 5,
        ]);

        Produto::query()->create([
            'nome' => 'Teclado Compacto',
            'descricao' => 'Teclado mecanico compacto',
            'preco' => 299.90,
            'quantidade' => 7,
        ]);

        $response = $this->getJson('/api/products?name=Mouse&min_price=29&max_price=400');

        $response
            ->assertOk()
            ->assertJsonPath('message', 'Lista de produtos')
            ->assertJsonCount(2, 'produtos')
            ->assertJsonFragment(['nome' => 'Mouse Gamer RGB'])
            ->assertJsonFragment(['nome' => 'Mouse Office'])
            ->assertJsonMissing(['nome' => 'Mouse Premium'])
            ->assertJsonMissing(['nome' => 'Teclado Compacto']);
    }

    public function test_retorna_a_resposta_do_endpoint_de_detalhe_do_produto(): void
    {
        $produto = Produto::query()->create([
            'nome' => 'Monitor UltraWide',
            'descricao' => 'Monitor de 34 polegadas',
            'preco' => 2899.90,
            'quantidade' => 3,
        ]);

        $response = $this->getJson("/api/product/{$produto->id}");

        $response
            ->assertOk()
            ->assertJsonPath('message', 'Produto encontrado com sucesso')
            ->assertJsonPath('produto.id', $produto->id)
            ->assertJsonPath('produto.nome', 'Monitor UltraWide')
            ->assertJsonPath('produto.preco', '2899.90');
    }
}
