<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    protected $Fadly_fillable = ['name'];

    public function getFillable()
    {
        return $this->Fadly_fillable;
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_role', 'role_id', 'UserID');
    }

}
