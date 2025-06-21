<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    public function test_it_can_create_a_category()
    {
        $category = Category::create([
        'name' => 'ordinateur',
        'description' => 'desc de ordinateur',
   
    ]);
        $this->assertDatabaseHas('categories', [
        'name' => 'ordinateur',
        ]);
    }
    public function test_it_can_update_a_category()
    {
        $category = Category::factory()->create();
        $category->update(['name' => 'ordinateur modifié']);
        $this->assertDatabaseHas('categories', ['name' => 'ordinateur modifié']);
    }
    public function test_it_can_delete_a_category()
    {
        $category = Category::factory()->create();
        $category->delete();
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}