<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

use App\Models\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    public function test_it_displays_the_category_list()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);
        Category::factory()->count(3)->create();
        $response = $this->get(route('admin.category.index'));
        $response->assertStatus(200);
        $response->assertSee('Categories');
    }
    public function test_it_can_create_a_category()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);
        $response = $this->post(route('admin.category.store'), [
        'name' => 'ordinateur',
        'description' => 'desc de ordinateur',
        ]);
        $this->assertDatabaseHas('categories', ['name' => 'ordinateur']);
        $response->assertRedirect(route('admin.category.index'));
    }
    
    public function test_it_can_update_a_category()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);
    $category = Category::factory()->create();
    $response = $this->put(route('admin.category.update', $category->id), [
    'name' => 'ordinateur modifié',
    ]);
    $this->assertDatabaseHas('categories', ['name' => 'ordinateur modifié']);
    $response->assertRedirect(route('admin.category.index'));
    }
    public function test_it_can_delete_a_category()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);
    $category = Category::factory()->create();
    $response = $this->delete(route('admin.category.destroy', $category->id));
    $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    $response->assertRedirect(route('admin.category.index'));
    }
}