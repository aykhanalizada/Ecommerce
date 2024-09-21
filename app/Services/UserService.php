<?php

namespace App\Services;

use App\Models\Media;
use App\Models\User;
use App\Notifications\WelcomeNewUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class UserService
{
    function getAllUsers()
    {
        return User::paginate(5);
    }

    public function storeUser(string $firstName, string $lastName, string $username, string $email, string $password, $file, int $isAdmin)
    {
        $user = User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'username' => $username,
            'email' => $email,
            'password' => Hash::make($password),
            'is_admin' => $isAdmin
        ]);

        if ($file) {
            $this->handleImageUpload($user, $file);
        }


        Notification::send($user, new WelcomeNewUser($user));

        return $user;

    }

    private function handleImageUpload($user, $file)
    {
        $fileExtension = $file->extension();
        $fileName = $file->hashName();

        Storage::disk('public')->putFileAs('images/users', $file, $fileName);

        $media = Media::create([
            'file_name' => $fileName,
            'file_type' => $fileExtension
        ]);
        $user->fk_id_media = $media->id_media;
        $user->save();
    }

    public function updateUser(
        int    $id,
        string $firstName,
        string $lastName,
        string $username,
        string $email,
        string $password = null,
               $image = null,
        int    $isAdmin)
    {
        $user = User::find($id);

        if (!$user) {
            return null;
        }


        $user->first_name = $firstName;
        $user->last_name = $lastName;
        $user->username = $username;
        $user->email = $email;
        if ($password) {
            $user->password = Hash::make($password);
        }
        $user->is_admin = $isAdmin;


        if ($image) {
            $this->deleteExistingImage($user);
            $this->handleImageUpload($user, $image);

        } else {
            $user->save();
        }
        return $user;


    }

    private function deleteExistingImage($user)
    {
        if (!$user->fk_id_media == null) {
            $filePath = ('images/users/') . $user->media->file_name;
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            $user->media()->update(['is_deleted' => 1, 'is_active' => 0]);
            $user->fk_id_media = null;
        }
    }

    public function destroyUser($id)
    {
        $user = User::where('id_user', $id)->first();

        if ($user) {
            $user->is_deleted = 1;
            $user->is_active = 0;


            $this->deleteExistingImage($user);

            $user->save();

            return $user;
        } else {
            return null;
        }


    }

    public function updateUserStatus(int $userId, bool $isActive)
    {

        $user = User::find($userId);

        $user->is_active = $isActive;
        $user->save();

        return $user;

    }


}
