<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeVisitFoto extends Model
{
    protected $fillable = [
        'home_visit_id',
        'foto',
    ];

    public function homeVisit()
    {
        return $this->belongsTo(HomeVisit::class);
    }
}