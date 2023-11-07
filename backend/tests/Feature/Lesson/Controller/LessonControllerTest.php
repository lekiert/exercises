<?php

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;

it('displays lessons list', function () {
    $user = User::factory()->create();

    Sanctum::actingAs($user, ['*']);

    /** @var \Illuminate\Http\JsonResponse $response */
    $response = $this->get('/api/lessons');

    $response->assertStatus(200);
    $response->assertJson(fn (AssertableJson $json) => $json->has('lessons'));
});

it('creates new lessons', function () {
    $user = User::factory()->create();

    Sanctum::actingAs($user, ['*']);

    $lesson = [
        'name' => 'New lesson',
        'description' => 'Some description',
    ];

    /** @var \Illuminate\Http\JsonResponse $response */
    $response = $this->post('/api/lessons', compact('lesson'));

    $response->assertStatus(200);
    $response->assertJson(fn (AssertableJson $json) => $json->has('lesson'));

    $this->assertDatabaseHas('lessons', [
        'name' => $lesson['name'],
        'description' => $lesson['description'],
    ]);
});

it('updates new lessons', function () {
    $user = User::factory()->create();

    Sanctum::actingAs($user, ['*']);

    $lesson = \App\Lesson\Model\Lesson::factory()
        ->create([
            'owner_id' => $user->id
        ]);

    $data = [
        'name' => 'Changed name',
        'description' => 'Changed description',
    ];

    /** @var \Illuminate\Http\JsonResponse $response */
    $response = $this->put('/api/lessons/'.$lesson->id, ['lesson' => $data]);

    $response->assertStatus(200);
    $response->assertJson(fn (AssertableJson $json) => $json->has('lesson'));

    $this->assertDatabaseHas('lessons', [
        'id' => $lesson->id,
        'name' => $data['name'],
        'description' => $data['description'],
    ]);
});
