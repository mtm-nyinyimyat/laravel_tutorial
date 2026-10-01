<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

test('guests cannot view the profile page', function () {
    $this->get(route('profile.edit'))->assertRedirect(route('login'));
});

test('authenticated users can view the profile edit page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('profile.edit'))
        ->assertOk()
        ->assertSee($user->name)
        ->assertSee($user->email)
        ->assertSee('Update password');
});

test('authenticated users can update their profile information', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->put(route('profile.update'), [
        'name' => 'Updated Name',
        'email' => 'updated@example.com',
    ]);

    $response->assertRedirect(route('profile.edit'));

    $user->refresh();

    expect($user->name)->toBe('Updated Name')
        ->and($user->email)->toBe('updated@example.com');
});

test('authenticated users can update their password', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->put(route('profile.password'), [
        'current_password' => 'password',
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ]);

    $response->assertRedirect(route('profile.edit'));

    expect(Hash::check('new-password', $user->fresh()->password))->toBeTrue();
});

test('password update requires the current password', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->from(route('profile.edit'))->put(route('profile.password'), [
        'current_password' => 'wrong-password',
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ]);

    $response->assertRedirect(route('profile.edit'))
        ->assertSessionHasErrors('current_password', errorBag: 'updatePassword');
});

test('profile email must be unique', function () {
    $user = User::factory()->create();
    User::factory()->create(['email' => 'taken@example.com']);

    $response = $this->actingAs($user)->from(route('profile.edit'))->put(route('profile.update'), [
        'name' => $user->name,
        'email' => 'taken@example.com',
    ]);

    $response->assertRedirect(route('profile.edit'))
        ->assertSessionHasErrors('email');
});
