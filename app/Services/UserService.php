<?php

namespace App\Services;

use App\Models\Media;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class UserService
{
    function getAllUsers()
    {
        return User::where('is_deleted', 0)
            ->paginate(5);
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


        return $user;

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
            $user->password = $password;
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


    public function updateUserStatus($request)
    {
        $request->validate([
            'is_active' => 'required|boolean',
            "id_user" => 'required'
        ]);

        $user = User::find($request->id_user);

        $user->is_active = $request->is_active;
        $user->save();

        Cache::forget('users');
        return $user;

    }


    private function handleImageUpload($user, $file)
    {
        $fileExtension = $file->extension();
        $fileName = $file->hashName();

        $path = public_path('images/users');
        $file->move($path, $fileName);

        $media = Media::create([
            'file_name' => $fileName,
            'file_type' => $fileExtension
        ]);
        $user->fk_id_media = $media->id_media;
        $user->save();
    }

    private function deleteExistingImage($user)
    {
        if (!$user->fk_id_media == null) {
            $filePath = ('images/users/') . $user->media->file_name;
            if (file_exists($filePath)) {
                unlink(public_path('images/users/') . $user->media->file_name);
            }
            $user->media()->update(['is_deleted' => 1, 'is_active' => 0]);
            $user->fk_id_media = null;
        }
    }


}
