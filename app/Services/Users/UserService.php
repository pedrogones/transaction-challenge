<?php

namespace App\Services\Users;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{

    public function getAll(): Collection
    {
        return User::with('roles')->orderBy('name')->get();
    }
    public function getAllPaginated(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return User::with('roles')->orderBy('name')->paginate();
    }

    public function create(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            if (!empty($data['roles'])) {
                $user->syncRoles($data['roles']);
            }

            return $user;
        });

    }

    public function update(User $user, array $data): User {
        return DB::transaction(function () use ($user, $data) {

            $updateData = [
                'name' => $data['name'],
                'email' => $data['email'],
            ];

            if (!empty($data['password'])) {
                $updateData['password'] = Hash::make($data['password']);
            }

            $user->update($updateData);
            $user->syncRoles($data['roles'] ?? []);
            return $user;
        });
    }

    public function findById(int $id): User
    {
        return User::with('roles')->findOrFail($id);
    }

    public function findBy(string $field, mixed $value): User
    {
        return User::where($field, $value)->firstOrFail();
    }

    public function delete(User $user): ?bool
    {
        return $user->delete();
    }


}
