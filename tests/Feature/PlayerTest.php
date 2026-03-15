<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Player;

class PlayerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
        /**
     * Test sobre endpoint /players
     */
    public function test_index_PlayerController_getPlayers_ReturnStatus200(): void
    {
        $ver = env("APP_VER");
        $response = $this->get("/{$ver}/players");
        $response->assertStatus(200);
    }

    /**
     * Test sobre endpoint /players
     * Uso de GET Players
     */
    public function test_index_PlayerController_getAllPlayers(): void
    {
        $players = Player::factory()->count(5)->create();

        $ver = env("APP_VER");
        $response = $this->get("/{$ver}/players");
        $response->assertStatus(200)
                 ->assertJsonCount(count: 5);

    }

    /**
     * Test sobre endpoint /players/{id}
     * Uso de GET Players
     */
    public function test_show_PlayerController_getPlayerId(): void
    {
        $player = Player::factory()->create();

        $ver = env("APP_VER");
        $response = $this->get("/{$ver}/players/{$player->id}");
        $response->assertStatus(200)
        ->assertJson([
            'id' => $player->id,
            'first_name' => $player->first_name, 
            'last_name' => $player->last_name, 
        ]);
    }

    /**
     * Test sobre endpoint /players/{id}
     * Uso de POST Players
     * Error
     */
    public function test_store_error_PlayerController_postPlayer(): void
    {
        $player = [
            'first_name' => 'Lucia',
            'last_name' => 'Fernandez',
            'date_birth' => '2018-01-01',
        ];

        $ver = env("APP_VER");
        $response = $this->postJson("/{$ver}/players", $player);
        $response->assertStatus(422);
    }

    /**
     * Test sobre endpoint /players/{id}
     * Uso de POST Players
     * CREACION
     */
    public function test_store_PlayerController_postPlayer(): void
    {
        $player = [
            'first_name' => 'Lucia',
            'last_name' => 'Fernandez',
            'date_birth' => '2018-01-01', 
            'gender' => 'female', 
        ];

        $ver = env("APP_VER");
        $response = $this->postJson("/{$ver}/players", $player);
        $response->assertStatus(201)
        ->assertJsonFragment([
            'first_name' => $player['first_name'], 
            'last_name' => $player['last_name'], 
        ]);
    }

    /**
     * Test sobre endpoint /players/{id}
     * Uso de PUT Players
     * ACTUALIZACIÓN
     */
    public function test_update_PlayerController_putPlayer(): void
    {
        $player = Player::factory()->create();

        $playerUpdate = [
            'first_name' => 'Lucia',
        ];

        $ver = env("APP_VER");
        $response = $this->putJson("/{$ver}/players/{$player->id}", $playerUpdate);
        $response->assertStatus(200)
        ->assertJsonFragment([
            'first_name' => $playerUpdate['first_name']
        ]);

    }

    /**
     * Test sobre endpoint /players/{id}
     * Uso de DELETE Players
     * BORRADO
     */
    public function test_delete_PlayerController_putPlayer(): void
    {
        $player = Player::factory()->create();

        $ver = env("APP_VER");
        $response = $this->deleteJson("/{$ver}/players/{$player->id}");
        $response->assertStatus(200);

    }
}
