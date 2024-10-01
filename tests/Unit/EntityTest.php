<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Entity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EntityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_an_entity()
    {
        $category = Category::create(['category' => 'Security']);

        $entity = Entity::create([
            'api' => 'Sample API',
            'description' => 'A sample API for testing',
            'link' => 'https://example.com',
            'category_id' => $category->id,
        ]);

        $this->assertDatabaseHas('entities', ['api' => 'Sample API']);
        $this->assertEquals('Sample API', $entity->api);
        $this->assertEquals('Security', $entity->category->category);
    }

    /** @test */
    public function it_requires_an_api_name()
    {
        $category = Category::create(['category' => 'Security']);
        $this->expectException(\Illuminate\Database\QueryException::class);

        Entity::create([
            'api' => null,
            'description' => 'A sample API for testing',
            'link' => 'https://example.com',
            'category_id' => $category->id,
        ]);
    }

    /** @test */
    public function it_requires_a_valid_category_id()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Entity::create([
            'api' => 'Sample API',
            'description' => 'A sample API for testing',
            'link' => 'https://example.com',
            'category_id' => 999,
        ]);
    }
}
