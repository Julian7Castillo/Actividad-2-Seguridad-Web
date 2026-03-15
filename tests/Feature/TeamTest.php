<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Team;

class TeamTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test sobre endpoint /teams
     */
    public function test_index_PlayerController_getPlayers_ReturnStatus200(): void
    {
        $ver = env("APP_VER");
        $response = $this->get("/{$ver}/teams");
        $response->assertStatus(200);
    }

    /**
     * Test sobre endpoint /teams
     * Uso de GET teams
     */
    public function test_index_TeamController_getAllTeams(): void
    {
        $teams = Team::factory()->count(5)->create();

        $ver = env("APP_VER");
        $response = $this->get("/{$ver}/teams");
        $response->assertStatus(200)
                 ->assertJsonCount(count: 5);

    }

    /**
     * Test sobre endpoint /teams/{id}
     * Uso de GET team
     */
    public function test_show_TeamController_getTeamId(): void
    {
        $team = Team::factory()->create();

        $ver = env("APP_VER");
        $response = $this->get("/{$ver}/teams/{$team->id}");
        $response->assertStatus(200)
        ->assertJson([
            'id' => $team->id,
            'name' => $team->name
        ]);
    }

    /**
     * Test sobre endpoint /teams/{id}
     * Uso de POST Teams
     * Error
     */
    public function test_store_error_TeamController_postTeam(): void
    {
        $team = [
            'name' => 'Equipo de baloncesto',
            'category' => 'incorrecta'
        ];

        $ver = env("APP_VER");
        $response = $this->postJson("/{$ver}/teams", $team);
        $response->assertStatus(422);
    }

    /**
     * Test sobre endpoint /teams/{id}
     * Uso de POST Teams
     * CREACION
     */
    public function test_store_TeamController_postTeam(): void
    {
        $team = [
            'name' => 'Equipo de baloncesto',
            'category' => 'infantiles',
            'gender' => 'female', 
        ];

        $ver = env("APP_VER");
        $response = $this->postJson("/{$ver}/teams", $team);
        $response->assertStatus(201)
        ->assertJsonFragment([
            'name' => $team['name'], 
        ]);
    }

    /**
     * Test sobre endpoint /players/{id}
     * Uso de PUT Players
     * ACTUALIZACIÓN
     */
    public function test_update_PlayerController_putPlayer(): void
    {
        $team = Team::factory()->create();

        $teamUpdate = [
            'name' => 'Equipo de baloncesto',
        ];

        $ver = env("APP_VER");
        $response = $this->putJson("/{$ver}/teams/{$team->id}", $teamUpdate);
        $response->assertStatus(200)
        ->assertJsonFragment([
            'name' => $teamUpdate['name']
        ]);

    }

    /**
     * Test sobre endpoint /teams/{id}
     * Uso de DELETE Team
     * BORRADO
     */
    public function test_delete_TeamController_putTeam(): void
    {
        $team = Team::factory()->create();

        $ver = env("APP_VER");
        $response = $this->deleteJson("/{$ver}/teams/{$team->id}");
        $response->assertStatus(200);

    }
}
