<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;

test('authed user can upload a file via api', function () {
  $user = User::factory()->create();
  $this->actingAs($user);

  $file = UploadedFile::fake()->create('document.jsonl', 1000);

  $response = $this->postJson(route('files.store'), [
    'file' => $file
  ]);

  $response->assertRedirectToRoute('start');
  $response->assertSessionHas('message');
});

// temporary?
test('unauthed user can upload a file via api', function () {
  $file = UploadedFile::fake()->create('document.jsonl', 1000);

  $response = $this->postJson(route('files.store'), [
    'file' => $file
  ]);

  $response->assertRedirectToRoute('start');
  $response->assertSessionHas('message');
});

// test('uploading a file creates a corpus', function () {
//   $user = User::factory()->create();
//   $this->actingAs($user);

//   $file = UploadedFile::fake()->create('document.jsonl', 1000);

//   $response = $this->postJson(route('files.store'), [
//     'file' => $file
//   ]);

//   $response->assertRedirectToRoute('start');
//   $response->assertSessionHas('message');

//   $this->assertCount(1, $user->corpora);
// });
