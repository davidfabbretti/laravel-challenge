<?php

namespace Tests\Unit;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     */
    /** @test */
    public function it_creates_a_category()
    {
        $category = Category::create(['category' => 'Animals']);

        $this->assertDatabaseHas('categories', ['category' => 'Animals']);
        $this->assertEquals('Animals', $category->category);
    }

    /** @test */
    public function it_requires_a_category_name()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Category::create(['category' => null]);
    }

    /** @test */
    public function it_does_not_create_duplicate_categories()
    {
        Category::create(['category' => 'Security']);
        $this->expectException(\Illuminate\Database\QueryException::class);

        Category::create(['category' => 'Security']);
    }
}
