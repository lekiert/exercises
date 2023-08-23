<?php

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

it('displays lessons list', function () {
    $user = User::factory()->create();

    /** @var \Illuminate\Http\JsonResponse $response */
    $response = $this
        ->actingAs($user)
        ->get('/api/lessons');

    $response->assertStatus(200);
    $response->assertJson(fn (AssertableJson $json) => $json->has('lessons'));
});
