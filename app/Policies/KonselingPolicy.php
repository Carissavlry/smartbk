<?php

namespace App\Policies;

use App\Models\Konseling;
use App\Models\User;

class KonselingPolicy
{
    public function view(User $user, Konseling $konseling): bool
    {
        return $user->id === $konseling->guru_bk_id;
    }

    public function update(User $user, Konseling $konseling): bool
    {
        return $user->id === $konseling->guru_bk_id;
    }

    public function delete(User $user, Konseling $konseling): bool
    {
        return $user->id === $konseling->guru_bk_id;
    }
}