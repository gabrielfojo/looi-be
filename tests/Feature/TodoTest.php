<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\Todo;
use App\Models\User;

class TodoTest extends TestCase
{

    use RefreshDatabase;

    private $user;

    protected $seed = true;

    protected function setUp(): void
    {
        parent::setup();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
        Todo::factory(5)->create(['user_id' => Auth::id()]);
    }


    /** @test */
    public function the_app_is_responding(): void
    {
        $response =  $this->get('/');
        $response->assertStatus(200);
    }

    /** @test */
    public function there_are_5_todos(): void
    {
        $response =  $this->getJson('/api/todo');
        $response->assertJsonCount(5);
    }

    /** @test */
    public function first_todo_is_shown(): void
    {
        $id = Auth::user()->todo->first()->id;
        $response =  $this->getJson("/api/todo/$id");
        $response->assertJsonFragment(["id" => $id]);
    }

    /** @test */
    public function delete_should_return_1(): void
    {
        $id = Auth::user()->todo->first()->id;

        $response =  $this->deleteJson("/api/todo/$id");
        $response->assertContent('1');
    }


    /** @test */
    public function delete_another_user_todo_returns_status_400(): void
    {
        $id = Auth::user()->todo->first()->id;
        $anotherUser = User::factory()->create();
        $this->actingAs($anotherUser);

        $response =  $this->deleteJson("/api/todo/$id");
        $response->assertStatus(400);
    }

    /** @test */
    public function a_todo_is_created(): void
    {
        $response = $this->postJson(
            '/api/todo',
            ['title' => 'To read', 'body' => 'YDKJS2 Closures']
        );
        $response->assertCreated();
    }

    /** @test */
    public function a_todo_is_updated(): void
    {
        $id = Auth::user()->todo->first()->id;
        $response = $this->getJson("/api/todo/$id");
        $json = $response->json();

        $response = $this->putJson(
            "/api/todo/$id",
            ['color' => '#000000', 'title' => 'This is a title', 'body' => 'This is a body']
        );

        $response->assertJsonFragment(['color' => '#000000']);
    }
}
