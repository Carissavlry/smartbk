<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'user_name',
        'role',
        'action',
        'module',
        'description',
        'subject_type',
        'subject_id',
        'ip_address',
        'user_agent',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper static — panggil dari mana saja
    public static function record(
        string $action,
        string $module,
        string $description = '',
        ?Model $subject = null
    ): void {
        $user = auth()->user();

        self::create([
            'user_id'      => $user?->id,
            'user_name'    => $user?->name,
            'role'         => $user?->getRoleNames()->first(),
            'action'       => $action,
            'module'       => $module,
            'description'  => $description,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id'   => $subject?->id,
            'ip_address'   => request()->ip(),
            'user_agent'   => request()->userAgent(),
        ]);
    }
}