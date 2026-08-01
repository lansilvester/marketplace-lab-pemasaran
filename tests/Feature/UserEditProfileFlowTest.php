<?php

namespace Tests\Feature;

use App\Http\Livewire\User\UserEditProfileComponent;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Tests\TestCase;

class UserEditProfileFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_replace_picture_deletes_old_file(): void
    {
        $user = User::factory()->create();
        Profile::factory()->create(['user_id' => $user->id, 'image' => 'old.jpg']);
        $dir = public_path('assets/images/profile');
        file_put_contents($dir.'/old.jpg', 'old');
        $old = $user->profile->image;

        $component = Livewire::actingAs($user)
            ->test(UserEditProfileComponent::class)
            ->set('latlong', '1.5, 124.8')
            ->set('newimage', UploadedFile::fake()->image('baru.jpg'))
            ->call('updateProfile');

        $new = $user->fresh()->profile->image;

        $this->assertNotSame($old, $new);
        $this->assertFileDoesNotExist($dir.'/old.jpg');
        $this->assertFileExists($dir.'/'.$new);
    }

    public function test_upload_first_picture_keeps_default_jpg(): void
    {
        $user = User::factory()->create();
        Profile::factory()->create(['user_id' => $user->id, 'image' => 'default.jpg']);
        $dir = public_path('assets/images/profile');

        Livewire::actingAs($user)
            ->test(UserEditProfileComponent::class)
            ->set('latlong', '1.5, 124.8')
            ->set('newimage', UploadedFile::fake()->image('avatar.png'))
            ->call('updateProfile');

        $this->assertFileExists($dir.'/default.jpg');
        $this->assertNotSame('default.jpg', $user->fresh()->profile->image);
    }

    public function test_delete_image_removes_file_and_nulls_column(): void
    {
        $user = User::factory()->create();
        Profile::factory()->create(['user_id' => $user->id, 'image' => 'foto.jpg']);
        $dir = public_path('assets/images/profile');
        file_put_contents($dir.'/foto.jpg', 'foto');

        Livewire::actingAs($user)
            ->test(UserEditProfileComponent::class)
            ->call('deleteImage');

        $this->assertFileDoesNotExist($dir.'/foto.jpg');
        $this->assertNull($user->fresh()->profile->image);
    }
}
