<?php

namespace Tests\Unit;

use App\ApiServices\ApiService;
use App\Models\Category;
use App\Models\Entity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ApiServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $apiService;

    public function setUp(): void
    {
        parent::setUp();
        $this->apiService = new ApiService();
    }

    /** @test */
    public function it_fetches_and_stores_data_from_api()
    {
        // Simular la respuesta de la API
        Http::fake([
            'http://web.archive.org/web/20240403172734/https://api.publicapis.org/entries' => Http::sequence()
                ->push([
                    'count' => 2,
                    'entries' => [
                        [
                            'API' => 'AdoptAPet',
                            'Description' => 'Resource to help get pets adopted',
                            'Link' => 'http://adoptapet.com',
                            'Category' => 'Animals',
                        ],
                        [
                            'API' => 'Security API',
                            'Description' => 'A sample security API',
                            'Link' => 'http://securityapi.com',
                            'Category' => 'Security',
                        ],
                    ],
                ]),
        ]);
        // ejecuto el servicio
        $this->apiService->getEntries();
        // Verificar que los datos se almacenaron correctamente
        $this->assertCount(2, Entity::all());
        $this->assertCount(2, Category::all());

        // Verificar que las entidades se crearon con los datos correctos
        $this->assertDatabaseHas('entities', [
            'api' => 'AdoptAPet',
            'description' => 'Resource to help get pets adopted',
            'link' => 'http://adoptapet.com',
        ]);

        $this->assertDatabaseHas('entities', [
            'api' => 'Security API',
            'description' => 'A sample security API',
            'link' => 'http://securityapi.com',
        ]);

        // Verificar que las categorías se crearon con los datos correctos
        $this->assertDatabaseHas('categories', ['category' => 'Animals']);
        $this->assertDatabaseHas('categories', ['category' => 'Security']);

    }
}
