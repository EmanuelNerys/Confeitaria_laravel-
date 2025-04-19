<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Bakery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

class BakeryRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_displays_the_bakery_index_page()
    {
        Bakery::factory()->count(3)->create();

        $response = $this->get(route('bakeries.index'));

        $response->assertInertia(fn (Assert $page) =>
            $page->component('Bakeries/Index') // Nome do componente Vue (verifique o caminho)
                 ->has('bakeries') // Ex: prop enviada pelo controller
        );
    }

    public function test_it_displays_the_create_bakery_form()
    {
        $response = $this->get(route('bakeries.create'));

        $response->assertInertia(fn (Assert $page) =>
            $page->component('Bakeries/Create')
        );
    }

    public function test_it_can_store_a_bakery()
    {
        $bakeryData = [
            'nome' => 'Confeitaria Teste',
            'latitude' => 10.0,
            'longitude' => 10.0,
            'cep' => '12345-678',
            'rua' => 'Rua Teste, 123',
            'numero' => '123',
            'bairro' => 'Bairro Teste',
            'cidade' => 'Cidade Teste',
            'estado' => 'Estado Teste',
            'telefone' => '1234-5678',
        ];

        $response = $this->post(route('bakeries.store'), $bakeryData);

        $response->assertRedirect(route('bakeries.index'));
        $response->assertSessionHas('success', 'Confeitaria cadastrada com sucesso!');
        $this->assertDatabaseHas('bakeries', $bakeryData);
    }

    public function test_it_can_search_cep()
    {
        $cep = '01001-000';

        $response = $this->get(route('cep.buscar', ['cep' => $cep]));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'cep', 'logradouro', 'bairro', 'localidade', 'uf',
        ]);
    }

    public function test_it_displays_the_edit_bakery_form()
    {
        $bakery = Bakery::factory()->create();

        $response = $this->get(route('bakeries.edit', ['bakery' => $bakery->id]));

        $response->assertInertia(fn (Assert $page) =>
            $page->component('Bakeries/Edit')
                 ->where('bakery.id', $bakery->id)
        );
    }

    public function test_it_can_update_a_bakery()
    {
        $bakery = Bakery::factory()->create();

        $updatedData = [
            'nome' => 'Confeitaria Atualizada',
            'latitude' => 11.0,
            'longitude' => 11.0,
            'cep' => '98765-432',
            'rua' => 'Rua Atualizada, 321',
            'numero' => '321',
            'bairro' => 'Bairro Atualizado',
            'cidade' => 'Cidade Atualizada',
            'estado' => 'Estado Atualizado',
            'telefone' => '9876-5432',
        ];

        $response = $this->put(route('bakeries.update', ['bakery' => $bakery->id]), $updatedData);

        $response->assertRedirect(route('bakeries.index'));
        $response->assertSessionHas('success', 'Confeitaria atualizada com sucesso!');
        $this->assertDatabaseHas('bakeries', $updatedData);
    }

    public function test_it_can_delete_a_bakery()
    {
        $bakery = Bakery::factory()->create();

        $response = $this->delete(route('bakeries.destroy', ['bakery' => $bakery->id]));

        $response->assertRedirect(route('bakeries.index'));
        $response->assertSessionHas('success', 'Confeitaria excluída com sucesso!');
        $this->assertDatabaseMissing('bakeries', ['id' => $bakery->id]);
    }

    public function test_it_requires_name_for_bakery()
    {
        $response = $this->post(route('bakeries.store'), []);

        $response->assertSessionHasErrors('nome');
    }
}
