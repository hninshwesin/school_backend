<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'seats'
    ];

    public function children()
    {
        return $this->belongsToMany(Child::class, 'school.child_class', 'class_id', 'child_id');
    }
}
