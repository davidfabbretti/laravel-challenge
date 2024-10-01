<?php

namespace Tests\Unit;


use App\Models\Category;
use App\Models\Entity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     */
    /** @test */
    public function it_returns_entities_by_category()
    {
        // Crear una categoría
        $category = Category::create(['category' => 'Animals']);

        // Crear algunas entidades asociadas a la categoría
        Entity::create([
            'api' => 'AdoptAPet',
            'description' => 'Resource to help get pets adopted',
            'link' => 'http://adoptapet.com',
            'category_id' => $category->id,
        ]);

        Entity::create([
            'api' => 'Cat Facts',
            'description' => 'Daily cat facts',
            'link' => 'http://catfacts.com',
            'category_id' => $category->id,
        ]);

        // Realizar la solicitud a la API
        $response = $this->getJson('/api/Animals');

        // Verificar que la respuesta sea correcta
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                [
                    'api' => 'AdoptAPet',
                    'description' => 'Resource to help get pets adopted',
                    'link' => 'http://adoptapet.com',
                ],
                [
                    'api' => 'Cat Facts',
                    'description' => 'Daily cat facts',
                    'link' => 'http://catfacts.com',
                ],
            ],
        ]);
    }

    /** @test */
    public function it_returns_not_found_for_non_existing_category()
    {
        // Realizar la solicitud a la API para una categoría que no existe
        $response = $this->getJson('/api/NonExistingCategory');

        // Verificar que se devuelva un estado 404
        $response->assertStatus(404);
        $response->assertJson([
            'success' => false,
            'message' => 'Category not found',
        ]);
    }
}
