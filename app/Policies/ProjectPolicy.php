<?php

namespace App\Policies;

use App\Models\User;

/**
 * MicuPanel is a single-tenant admin panel: the authenticated user is the
 * owner/operator of every record. Authorization therefore reduces to "is
 * authenticated", but the policy is kept explicit so per-user or per-team
 * ownership rules can be introduced later without touching controllers.
 */
class ProjectPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user): bool
    {
        return true;
    }

    public function delete(User $user): bool
    {
        return true;
    }
}
