<?php

namespace App\Traits;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

trait HasRoles
{
    /**
     * User's assigned roles.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }

    /**
     * Check if user has a specific role or one of given roles.
     */
    public function hasRole(string|array $roles): bool
    {
        $roleList = is_array($roles) ? $roles : func_get_args();

        return $this->roles->contains(function (Role $role) use ($roleList) {
            return in_array($role->slug, $roleList, true);
        });
    }

    /**
     * Assign a role to user.
     */
    public function assignRole(string|Role $role): self
    {
        if (is_string($role)) {
            $role = Role::where('slug', $role)->firstOrFail();
        }

        $this->roles()->syncWithoutDetaching([$role->id]);
        $this->unsetRelation('roles');

        return $this;
    }

    /**
     * Remove a role from user.
     */
    public function removeRole(string|Role $role): self
    {
        if (is_string($role)) {
            $role = Role::where('slug', $role)->firstOrFail();
        }

        $this->roles()->detach($role->id);
        $this->unsetRelation('roles');

        return $this;
    }

    /**
     * Check if user has a specific permission via any assigned role.
     */
    public function hasPermission(string $permissionSlug): bool
    {
        // Super admin has all permissions
        if ($this->hasRole('super_admin')) {
            return true;
        }

        return $this->allPermissions()->contains('slug', $permissionSlug);
    }

    /**
     * Get all flattened permissions for user.
     */
    public function allPermissions(): Collection
    {
        return $this->roles->loadMissing('permissions')
            ->pluck('permissions')
            ->flatten()
            ->unique('id');
    }

    /**
     * Get primary role name for display.
     */
    public function primaryRoleName(): string
    {
        return $this->roles->first()?->name ?? 'Pengguna';
    }
}
