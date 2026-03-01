<?php

namespace App\Services\Roles;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleService
{

    public function getAllPermissions()
    {
        return Permission::orderBy('name')->get();
    }

    public function create(array $data): Role
    {
        return DB::transaction(function () use ($data) {
            $role = Role::create(['name' => $data['name']]);

            if (!empty($data['permissions'])) {
                $role->syncPermissions($data['permissions']);
            }

            return $role;
        });

    }

    public function update(Role $role, array $data): Role {
        return DB::transaction(function () use ($role, $data) {
            $role->update([
                'name' => $data['name'],
            ]);

            $role->syncPermissions($data['permissions'] ?? []);

            return $role;
        });
    }

    public function findById(int $id): Role
    {
        return Role::findOrFail($id);
    }

    public function findBy(string $field, mixed $value): Role
    {
        return Role::where($field, $value)->firstOrFail();
    }

    public function getAll(): Collection
    {
        return Role::where('guard_name', 'web')
            ->orderBy('name')
            ->get();
    }

    public function delete(Role $role): ?bool
    {
        return $role->delete();
    }


}
