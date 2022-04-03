<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Child extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'age', 'app_user_id'
    ];

    public function classes()
    {
        return $this->belongsToMany(Classes::class, 'school.child_class', 'child_id', 'class_id');
    }
}
